function randomColor(min, max) {
    var b = Math.floor(Math.random() * (max - min + 1) + min);
    var g = Math.floor(Math.random() * (max - min + 1) + min);
    var r = Math.floor(Math.random() * (max - min + 1) + min);
    var color = 'rgba(' + r + ',' + g + ',' + b + ',1)';
    changeColor(color);
}

function changeColor(color)
{
	var url = CONSTANTS.BASE_URL + "/php/scripts/change-color.php";
    document.body.style.backgroundColor = color;
    color = encodeURIComponent(color);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send('color=' + color);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) { 
            
        }
    };
}
