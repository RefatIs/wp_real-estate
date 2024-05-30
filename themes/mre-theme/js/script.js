document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('property-upload-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', ajax_object.ajax_url, true);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                document.getElementById('upload-results').innerHTML = xhr.responseText;
            } else {
                document.getElementById('upload-results').innerHTML = 'There was an error uploading your files.';
            }
        };

        xhr.onerror = function () {
            document.getElementById('upload-results').innerHTML = 'There was an error uploading your files.';
        };

        formData.append('action', 'upload_property');

        xhr.send(formData);
    });
});