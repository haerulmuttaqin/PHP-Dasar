var keyword = document.getElementById('keyword');
keyword.addEventListener('keyup', function() {
    
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (keyword.value == ""){
                window.location.href = 'index.php';
            }
            document.getElementById('pager').innerHTML = '<br />';
            document.getElementById('container').innerHTML = this.responseText;
        }
    }

    xhr.open("GET", "ajax/keyword.php?keyword=" + keyword.value, true);
    xhr.send();

});