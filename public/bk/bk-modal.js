/**
 * 燈箱啟動
 * @param {string} id 燈箱 ID(啟動時可傳可不傳，不傳就是亂數產)
 */
function bkModalInit(id) {
    /**
     * 隨機產生一組亂數ID
     * @returns 一組隨機亂數ID
     */
    function randomModalID() {
      return 'bk-modal-xxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = (Math.random() * 16) | 0,
          v = c == 'x' ? r : (r & 0x3) | 0x8;
        return v.toString(16);
      });
    }
    const modalID = id || randomModalID();
    console.log('modalID = ',modalID)

    const modalDOM = `<div id="${modalID}" class="bk-modal"><div class="bk-modal-scroller"><div class="bk-modal-wrapper"><div class="bk-modal-content"><svg class="loader" version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" style=""><path fill="#202020" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50"><animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" /></path></svg></div></div></div></div>`;
    $('body').append(modalDOM);
    // $('.bk-modal').on('click', function () {
    //   bkModalClose(modalID);
    // });
    $('.bk-modal').on('click', '.modal-close', function () {
      bkModalClose(modalID);
    });
    $('.bk-modal').on('click', '.modal-destroy', function () {
      bkModalDestroy(modalID);
    });
    $('.bk-modal').on('click', '.bk-modal-content', function (e) {
      e.stopPropagation();
    });
  }

  /**
   * 打開燈箱
   * @param {string} id 燈箱 ID
   * @param {function} callback 燈箱打開後要執行的 callback
   */
  function bkModalOpen(id, callback) {
    $(`#${id}`)
      .fadeIn(300)
      .promise()
      .done(function () {
        if (typeof callback === 'function') {
          callback();
        }
      });
  }

  /**
   * 關閉燈箱
   * @param {string} id 燈箱 ID
   */
  function bkModalClose(id) {
    $(`#${id}`)
      .fadeOut(300)
      .promise()
      .done(function () {});
  }

  /**
   * 銷毀燈箱
   * @param {string} id 燈箱 ID
   */
  function bkModalDestroy(id) {
    $(`#${id}`)
      .fadeOut(300)
      .promise()
      .done(function () {
        $(`#${id}`).remove();
      });
  }

  /**
   * 燈箱載入完成
   * @param {string} id 燈箱 ID
   */
  function bkModalLoaded(id) {
    $(`#${id} .loader`).fadeOut(300);
  }

