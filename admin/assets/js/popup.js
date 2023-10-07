
function openPopup() {
  var popup = document.getElementById("popup");
  popup.style.display = "block";
}

function closePopup() {
  var popup = document.getElementById("popup");
  popup.style.display = "none";
}


$(document).ready(function() {
    $('.popup').click(function() {
      var row = $(this).closest('tr').find('name');
      var name = row.find('name').text();
      var bp = row.find('bp').text();
      var designation = row.find('td:designation').text();
      // open popup view and display data
    });
  });
  