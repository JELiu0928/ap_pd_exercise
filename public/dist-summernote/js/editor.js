window.editorInit = function() {
    // console.log('window.editorInit')
  // summernote basis
  // $('.summernote-area').summernote({
  //   placeholder: 'Type some words ...',
  //   tabsize: 2,
  //   height: 250,
  //   lang: 'zh-TW',
  //   toolbar: [['font', ['bold', 'underline']], ['para', ['ul', 'ol']], ['insert', ['link']]],
  //   icons: {
  //     bold: 'icon-bold',
  //     underline: 'icon-underline',
  //     link: 'icon-link'
  //   },
  //   callbacks: {
  //     onImageUpload: function onImageUpload(data) {
  //       data.pop();
  //     }
  //   }
  // });

  // $('i.note-icon-font').addClass('icon-hilite-color').removeClass('note-icon-font');
  // $('i.note-icon-unorderedlist').addClass('icon-ul').removeClass('note-icon-unorderedlist');
  // $('i.note-icon-orderedlist').addClass('icon-ol').removeClass('note-icon-orderedlist');

  // // prevent html tags which is copied from other site
  // function textPaste(event) {
  //   console.log(event);
  //   event.preventDefault();
  //   var text = void 0;
  //   var clp = (event.originalEvent || event).clipboardData;
  //   if (clp === undefined || clp === null) {
  //     text = window.clipboardData.getData("text") || "";
  //     if (text !== "") {
  //       var newNode = document.createElement("span");
  //       newNode.innerHTML = text;
  //       window.getSelection().getRangeAt(0).insertNode(newNode);
  //     }
  //   } else {
  //     text = clp.getData('text/plain') || "";
  //     if (text !== "") {
  //       document.execCommand('insertText', false, text);
  //     }
  //   }
  // }

  // setTimeout(function () {
  //   var noteEditor = document.querySelectorAll('.note-editor .note-editable')
  //   if (!noteEditor) return;
  //   noteEditor.forEach(function(item) {
  //     if ($(item).hasClass('is-active')) return;
  //     item.addEventListener('paste', function (e) {
  //       textPaste(e);
  //     });
  //     item.classList.add('is-active')
  //   })
  // }, 400);
}
