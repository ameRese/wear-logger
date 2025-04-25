document.addEventListener('DOMContentLoaded', function () {
    const imageUpload = document.getElementById('js-image-upload');
    const imagePreview = document.getElementById('js-image-preview');
    const reader = new FileReader();

    reader.addEventListener('load', function () {
        imagePreview.src = reader.result;
    });

    imageUpload.addEventListener('change', function () {
        reader.readAsDataURL(imageUpload.files[0]);
    });
});
