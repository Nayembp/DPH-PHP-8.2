  // Get the table and pagination elements
  var table = document.querySelector('.table');
  var pagination = document.querySelector('.pagination');

  // Define a function to update the pagination links
  function updatePagination() {
    // Get the number of rows per page from the data-bs-items-per-page attribute
    var itemsPerPage = parseInt(pagination.getAttribute('data-bs-items-per-page'));

    // Calculate the total number of pages based on the number of rows and the rows per page
    var rowCount = table.tBodies[0].rows.length;
    var pageCount = Math.ceil(rowCount / itemsPerPage);

    // Remove any existing pagination links
    pagination.innerHTML = '';

    // Add the Previous link
    var li = document.createElement('li');
    li.classList.add('page-item', 'disabled');
    var a = document.createElement('a');
    a.classList.add('page-link');
    a.href = '#';
    a.tabIndex = -1;
    a.setAttribute('aria-disabled', 'true');
    a.innerText = 'Previous';
    li.appendChild(a);
    pagination.appendChild(li);

    // Add the numbered page links
    for (var i = 1; i <= pageCount; i++) {
      var li = document.createElement('li');
      li.classList.add('page-item');
      if (i == 1) {
        li.classList.add('active');
        li.setAttribute('aria-current', 'page');
      }
      var a = document.createElement('a');
      a.classList.add('page-link');
      a.href = '#';
      a.innerText = i.toString();
      li.appendChild(a);
      pagination.appendChild(li);
    }

    // Add the Next link
    var li = document.createElement('li');
    li.classList.add('page-item');
    if (pageCount == 1) {
      li.classList.add('disabled');
}