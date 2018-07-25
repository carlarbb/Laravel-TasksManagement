window.onload = function() {
    var check = this.document.getElementById('sort');
    var a = check.getElementsByTagName('input');
    for (var i = 0; i < a.length; i++) {

        console.log(this.value);

    }
}