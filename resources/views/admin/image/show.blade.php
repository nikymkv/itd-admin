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
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalChangeOrientation">
    Change Orientation
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
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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
                    <input type="range" name="resizeRange[width]" min="0" max="100" step="1" value="50">
                    <input type="range" name="resizeRange[heigth]" min="0" max="100" step="1" value="50">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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
                <button type="button" class="btn btn-primary">Save changes</button>
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
                <button type="button" class="btn btn-primary" onclick="compressHandle()">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Change Orientation -->
<div class="modal fade" id="modalChangeOrientation" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change orientation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    function uploadPhoto() {
        const fileInput = document.getElementById('upload_photo')
        let formData = new FormData()
        let image = fileInput.files[0]
        rePrintMeta(image.size)
        formData.append('uploadImage', image)
        axios.post('http://itd-admin.loc/admin/image', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (response) {
                url = response.data.url
                changeImage(url)
                console.log('success', response.data)
            })
    }

    function compressPhoto() {
        let formData = new FormData()
        let image = fileInput.files[0]
        rePrintMeta(image.size)
        axios.post('http://itd-admin.loc/admin/image/handle', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (data) {
                console.log('success', data)
            })
            .catch(function (data) {
                console.log('success', data)
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
        axios.post('http://itd-admin.loc/admin/image/handle', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (data) {
                console.log('success', data)
            })
            .catch(function (data) {
                console.log('success', data)
            })
    }

</script>
@endsection
