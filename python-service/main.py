from fastapi import FastAPI
from fastapi import UploadFile
from fastapi import File
from fastapi import HTTPException

from fastapi.responses import FileResponse

from pypdf import PdfReader
from pypdf import PdfWriter

from reportlab.pdfgen import canvas
from reportlab.lib.utils import ImageReader

from PIL import Image

from fastapi import BackgroundTasks

import tempfile
import os

app = FastAPI()


@app.get("/")
def health():
    return {
        "status": "ok"
    }


@app.post("/test-upload")
async def test_upload(
    file: UploadFile
):
    return {
        "filename": file.filename
    }

def create_watermark_pdf(
    image_path,
    output_path,
    page_width,
    page_height
):
    c = canvas.Canvas(
        output_path,
        pagesize=(page_width, page_height)
    )

    watermark_width = page_width * 0.35
    watermark_height = watermark_width

    x = (
        page_width -
        watermark_width
    ) / 2

    y = (
        page_height -
        watermark_height
    ) / 2

    c.drawImage(
        ImageReader(image_path),
        x,
        y,
        width=watermark_width,
        height=watermark_height,
        mask='auto'
    )

    c.save()


def create_transparent_watermark(
    image_path,
    opacity=0.35
):
    image = Image.open(
        image_path
    ).convert("RGBA")

    alpha = image.getchannel("A")

    alpha = alpha.point(
        lambda p: int(p * opacity)
    )

    image.putalpha(alpha)

    output = tempfile.NamedTemporaryFile(
        delete=False,
        suffix=".png"
    )

    image.save(
        output.name,
        "PNG"
    )

    return output.name

@app.post("/watermark")
async def watermark(
    background_tasks: BackgroundTasks,
    pdf_file: UploadFile = File(...),
    watermark_image: UploadFile = File(...)
):

    try:

        if not pdf_file.filename.lower().endswith(
            (".pdf", ".tmp")
        ):
            raise HTTPException(
                status_code=400,
                detail="Invalid PDF file"
            )

        allowed_images = [
            "image/png",
            "image/jpeg"
        ]

        if not watermark_image.filename.lower().endswith(
            (".png", ".jpg", ".jpeg", ".tmp")
        ):
            raise HTTPException(
                status_code=400,
                detail="Invalid image file"
            )
        
        pdf_temp = tempfile.NamedTemporaryFile(
            delete=False,
            suffix=".pdf"
        )

        pdf_temp.write(await pdf_file.read())
        pdf_temp.close()

        image_temp = tempfile.NamedTemporaryFile(
            delete=False,
            suffix=".png"
        )

        image_temp.write(await watermark_image.read())
        image_temp.close()

        watermark_pdf = tempfile.NamedTemporaryFile(
            delete=False,
            suffix=".pdf"
        )

        watermark_pdf.close()

        transparent_image = (
            create_transparent_watermark(
                image_temp.name,
                0.35
            )
        )

        reader = PdfReader(
            pdf_temp.name
        )

        first_page = reader.pages[0]

        page_width = float(
            first_page.mediabox.width
        )

        page_height = float(
            first_page.mediabox.height
        )

        create_watermark_pdf(
            transparent_image,
            watermark_pdf.name,
            page_width,
            page_height
        )

        writer = PdfWriter()

        watermark_reader = PdfReader(
            watermark_pdf.name
        )

        watermark_page = watermark_reader.pages[0]

        for page in reader.pages:

            page.merge_page(
                watermark_page
            )

            writer.add_page(page)

        output_pdf = tempfile.NamedTemporaryFile(
            delete=False,
            suffix=".pdf"
        )

        output_pdf.close()

        with open(
            output_pdf.name,
            "wb"
        ) as output_file:

            writer.write(output_file)

        temp_files = [
            pdf_temp.name,
            image_temp.name,
            watermark_pdf.name,
            transparent_image
        ]

        for file in temp_files:
            background_tasks.add_task(
                os.remove,
                file
            )

        background_tasks.add_task(
            os.remove,
            output_pdf.name
        )

        return FileResponse(
            output_pdf.name,
            media_type="application/pdf",
            filename="processed.pdf"
        )

    except HTTPException:
        raise

    except Exception as e:
        raise HTTPException(
            status_code=500,
            detail=str(e)
        )