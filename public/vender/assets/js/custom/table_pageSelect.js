; (function () {



  var pageBtn = Array.apply(null, document.querySelectorAll('.page-btn'))

  var pageNum = Array.apply(null, document.querySelectorAll('.pageNum'))



  function closeAll() {

    pageBtn.forEach(function (closeObj) {

      closeObj.classList.remove('active')

    })

  }



  pageBtn.forEach(function (obj) {

    if (obj.classList.contains('nowPage')) {

      obj.querySelector('.nowPageNum').innerText = obj.dataset.page

    }

    obj.addEventListener('click', function () {

      if (this.classList.contains('active')) {

        this.classList.remove('active')

      }

      else {

        closeAll()

        if (this.classList.contains('nowPage')) {

          this.classList.add('active')

        }

      }

    })

  })



  pageNum.forEach(function (obj) {

    obj.addEventListener('click', function (e) {

      var pageClick = this.dataset.page

      closeAll()

      e.stopPropagation()

    })

  })





})()