
$(function() {
  $('#commentform').submit(handleSubmit);
});

function handleSubmit() {
  let form = $(this);
  // let data = {
  //   "comment_author": form.find('#comment_author').val(),
  //   "email": form.find('#email').val(),
  //   "comment": form.find('#comment').val(),
  //   "comment_post_ID": form.find('#comment_post_ID').val(),
  //   "date": new Date()
  // };

  let data = {
    "comment_author": "Aakib",
    "email": "aakib@uconn.edu",
    "comment": "testing",
    "comment_post_ID": 1,
    "date": new Date()
  };

  // var dataJson = JSON.stringify(data);

  var newData = form.serialize();

  postComment(newData);

  // postSuccess(data);

  return false;
}

function postComment(data) {
  $.ajax({
    type: 'POST',
    url: 'post_comment.php',
    data: data,
    contentType: "application/json; charset=utf-8", // this
    dataType: "json", // and this
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    },
    success: function () {
      postSuccess(data);
    },
    error: function () {
      postError();
    }
  });
}

function postError(jqXHR, textStatus, errorThrown) {
  // display error
}


function postSuccess(data, textStatus, jqXHR) {
  $('#commentform').get(0).reset();

  displayComment(data);
}

function displayComment(data) {
  var commentHtml = createComment(data);
  var commentEl = $(commentHtml);
  commentEl.hide();
  var postsList = $('#posts-list');
  postsList.addClass('has-comments');
  postsList.prepend(commentEl);
  commentEl.slideDown();
}

 function createComment(data) {
   var html = '<li><article id="' + data.comment_post_ID + '" class="hentry">' +
    '<footer class="post-info">' +
      '<abbr class="published" title="' + data.date + '">' +
        parseDisplayDate(data.date) +
      '</abbr>' +
      '<address class="vcard author">' +
        'By <a class="url fn" href="#">' + data.comment_author + '</a>' +
      '</address>' +
    '</footer>' +
    '<div class="entry-content">' +
      '<p>' + data.comment + '</p>' +
    '</div>' +'</article></li>';

  return html;
}

function parseDisplayDate(date) {
  date = (date instanceof Date? date : new Date( Date.parse(date) ) );
  return date.getDate() + ' ' +
      ['January', 'February', 'March',
        'April', 'May', 'June', 'July',
        'August', 'September', 'October',
        'November', 'December'][date.getMonth()] + ' ' +
      date.getFullYear() + ' ' + date.toLocaleTimeString();
}