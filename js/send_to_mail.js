var rowcnt = 0;
$(function(){

   function deleteRow(num) {
      $('#row' + num).remove();
      for (var j = num + 1; j <= rowcnt; j++) {
         var new_num = j - 1;
         var row = $('#row' + j);
         row.attr('id', 'row' + new_num);
         row.children(":first").html(new_num);
      }
      rowcnt--;
      $.fancybox.center();
   }

   var options = {
      beforeSend: function() {
         $('#proposal').find('#mode').val("Insert");
         // console.log($('#proposal').find('#mode').val());
      },
      uploadProgress: function(event, position, total, percentComplete) {
         console.log('upload progress');
      },
      success: function() {
         console.log('success');
      },
      complete: function(response) {
         console.log('complete');
         console.log(JSON.stringify(response));
         console.log(response.responseText);
         var data = $.parseJSON(response.responseText);

         if (data.result) {
            $('#category_choose li').removeClass('active');
            $('#send_window').find('.form-control').each(function() {
               $(this).val('');
            });
            while (rowcnt > 0) {
               deleteRow(rowcnt);
            }
            $.fancybox(
               '<span style="color: green; font-weight: bold; display: block; margin: 30px;">Заявка отправлена! Спасибо!</span>',
               {
                  'autoDimensions'  : false,
                  'width'           : 360,
                  'height'          : 'auto',
                  'transitionIn'    : 'none',
                  'transitionOut'   : 'none'
               }
            );
         } else {
           $.fancybox(
               '<span style="color: red; font-weight: bold; display: block; margin: 30px;">' + data.message + '</span>',
               {
                  'autoDimensions'  : false,
                  'width'           : 360,
                  'height'          : 'auto',
                  'transitionIn'    : 'none',
                  'transitionOut'   : 'none'
               }
            );
         }
      }
   };

   $('#proposal').ajaxForm(options);

   function fakeInputChange() {
      rowcnt++;
      var fileName = document.getElementById("fake_input").value;
      var cell_classes = ["num", "name", "delete"];
      var cell_names = [rowcnt, fileName, "Удалить"];
      var table = document.getElementsByClassName("attachments")[0];
      var row = table.insertRow(-1);
      row.setAttribute('id', 'row' + rowcnt);
      var cells = [];
      for (var i = 0; i < 3; i++) {
         cells[i] = document.createElement("td");
         cells[i].className = cell_classes[i];
         cells[i].innerHTML = cell_names[i];
         row.appendChild(cells[i]);
      }

      cells[2].onclick = function() {
         deleteRow(parseInt(cells[2].parentNode.firstChild.innerHTML));
      };
      var parent = $(this).parent();
      $(this).appendTo(row);
      $(this).toggleClass("file_input");
      $(this).attr('id', 'fi' + rowcnt);
      $(this).attr('name', 'fi' + rowcnt);
      $(this).onchange = function() {
         var fileName = document.getElementById("fi" + rowcnt).value;
         if (fileName) {
            $('#row' + rowcnt).find("td").eq(1).html(fileName);
            $('#row' + rowcnt).toggleClass("active");
            $.fancybox.center();
         }
      };
      var fakeInput = document.createElement("input");
      fakeInput.type="file";
      fakeInput.setAttribute('id', 'fake_input');
      fakeInput.onchange = fakeInputChange;
      parent.append(fakeInput);
      $.fancybox.center();
   }

   $('#fake_input').change(fakeInputChange);

   $('#add_file').click(function() {
      $('#fake_input').click();
   });
});