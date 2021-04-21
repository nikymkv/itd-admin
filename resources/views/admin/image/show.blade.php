@extends('layouts.app')
@section('content')
<input type="file" name="image" id="upload_photo" onchange="uploadPhoto()"> <br>
<label for="sizeLabel">Размер изображения</label>
<input type="text" name="sizeLabel" id="sizeLabel" size="2" readonly> MB
<br>
<img src="" id="image" alt="">

<br>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCrop">
    Crop
</button>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalResize">
    Resize
</button>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalWatermark">
    Watermark
</button>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCompress">
    Compress
</button>

<!-- Modal Crop -->
<div class="modal fade" id="modalCrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crop image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <label for="widthCropInput">Ширина</label>
                    <input type="number" name="widthCropInput" id="widthCropInput">
                </div>

                <div>
                    <label for="heightCropInput">Высота</label>
                    <input type="number" name="heightCropInput" id="heightCropInput">
                </div>

                <div>
                    <label for="xCropInput">Начать от X:</label>
                    <input type="number" name="xCropInput" id="xCropInput">
                </div>

                <div>
                    <label for="yCropInput">Начать от Y:</label>
                    <input type="number" name="yCropInput" id="yCropInput">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="cropHandle()" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Resize -->
<div class="modal fade" id="modalResize" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Resize image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="resizeForm">
                    @csrf
                    <div>
                        <label for="widthInput">Ширина</label>
                        <input type="text" name="width" id="widthInput">
                    </div>
                    <div>
                        <label for="heightInput">Высота</label>
                        <input type="text" name="height" id="heightInput">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="resizeHandle()" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Watermark -->
<div class="modal fade" id="modalWatermark" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add watermark</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="watermarkHandle()" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Compress -->
<div class="modal fade" id="modalCompress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Compress image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="number" name="quality" id="qualityInput"> Степень сжатия
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="compressHandle()" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>

<button type="button" class="btn btn-primary" onclick="rotateHandle()">Change Orientation</button>

<script type="application/javascript">
    function uploadPhoto() {
        const fileInput = document.getElementById('upload_photo')
        let formData = new FormData()
        let image = fileInput.files[0]
        formData.append('uploadImage', image)
        axios.post("{{ route('admin.save-image') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (response) {
                console.log(response)
                changeImage(response.data.url)
                rePrintMeta(response.data.filesize)
            })
    }

    function changeImage(url) {
        let image = document.getElementById('image');
        image.src = url
    }

    function rePrintMeta(size) {
        var sizeLabel = document.getElementById('sizeLabel')
        sizeLabel.value = Math.round((size / 1000000) * 100) / 100
    }

    function compressHandle() {
        let path = document.getElementById('image').src.split('/').pop();
        let quality = document.getElementById('qualityInput').value
        let formData = new FormData()
        formData.append('type', 'compress')
        formData.append('option[quality]', quality)
        formData.append('path', path)
        axios.post("{{ route('admin.handle-image') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (response) {
                changeImage(response.data.url)
                rePrintMeta(response.data.filesize)
            })
            .catch(function (response) {
                console.log('success', response)
            })
    }

    function resizeHandle() {
        let path = document.getElementById('image').src.split('/').pop();
        let width = document.getElementById('widthInput').value;
        let height = document.getElementById('heightInput').value;
        let formData = new FormData()
        formData.append('type', 'resize')
        formData.append('option[width]', width)
        formData.append('option[height]', height)
        formData.append('path', path)
        axios.post("{{ route('admin.handle-image') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (response) {
                changeImage(response.data.url)
                rePrintMeta(response.data.filesize)
            })
            .catch(function (response) {
                console.log('success', response)
            })
    }

    function rotateHandle() {
        let path = document.getElementById('image').src.split('/').pop();
        let formData = new FormData()
        formData.append('type', 'changeOrientation')
        formData.append('path', path)
        axios.post("{{ route('admin.handle-image') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (response) {
                changeImage(response.data.url)
                rePrintMeta(response.data.filesize)
            })
            .catch(function (response) {
                console.log('success', response)
            })
    }

    function cropHandle() {
        let path = document.getElementById('image').src.split('/').pop();
        let width = document.getElementById('widthCropInput').value
        let height = document.getElementById('heightCropInput').value
        let x = document.getElementById('xCropInput').value
        let y = document.getElementById('yCropInput').value
        let formData = new FormData()
        formData.append('type', 'crop')
        formData.append('option[width]', width)
        formData.append('option[height]', height)
        formData.append('option[x]', x)
        formData.append('option[y]', y)
        formData.append('path', path)
        axios.post("{{ route('admin.handle-image') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (response) {
                changeImage(response.data.url)
                rePrintMeta(response.data.filesize)
            })
            .catch(function (response) {
                console.log('success', response)
            })
    }

    function watermarkHandle() {
        let path = document.getElementById('image').src.split('/').pop();
        let formData = new FormData()
        formData.append('type', 'watermark')
        formData.append('path', path)
        axios.post("{{ route('admin.handle-image') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (response) {
                changeImage(response.data.url)
                rePrintMeta(response.data.filesize)
            })
            .catch(function (response) {
                console.log('success', response)
            })
    }
</script>
@endsection
