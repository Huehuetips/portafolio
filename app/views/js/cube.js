var cube  = document.getElementById('cube'),
    lleno = false;
if (cube) {
  cube.addEventListener("click",(event) => getCube())
}



// getCube();
function getCube() {
  $.ajax({
    url: 'app/views/js/PostAjax/rubickMix.php',
    type: 'POST',
    data: {lleno: lleno}
  }).done(function (resp) {
    cube.innerHTML= resp;
  });
  lleno= !lleno;
}