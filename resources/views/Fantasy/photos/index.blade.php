@extends('Fantasy.template')

@section('bodySetting', 'fixed-header photos_theme')

  @section('css')
    <!--cropperjs-master(2019/09/08 引入) -->
    <link type="text/css" rel="stylesheet" href="/vender/assets/css/cropperjs-master/cropper.css" />
  @stop

  @section('css_back')

  @stop

@section('content')

  <!-- 左邊滑動的 sidebar -->
  @include('Fantasy.includes.sidebar')
  <!-- 左邊滑動的 sidebar -->


  <!-- 中間主區塊 -->
  <div class="mainBody page-container extract-block">

    <!-- 最上面的 header bar -->
    @include('Fantasy.includes.header')
    <!-- 最上面的 header bar -->

    <div class="page-content-wrapper mainContent full-height">
      <div class="content full-height">

        <!-- 右邊 PAGE CONTENT -->
        <div class="inner-content">

          <!-- 下面列表 -->
          <div class="content-scrollbox">
            <div class="photosBody">
              <div class="photosToolNav">
                <!-- <h3>Toolbar:</h3> -->
                <div class="navGroup">
                  <div class="navBt" data-method="setDragMode" data-option="move" title="Move">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
                      <span class="fa fa-arrows"></span>
                    </span>
                  </div>
                  <div class="navBt" data-method="setDragMode" data-option="crop" title="Crop">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
                      <span class="fa fa-crop"></span>
                    </span>
                  </div>
                </div>

                <div class="navGroup">
                  <div class="navBt" data-method="zoom" data-option="0.1" title="Zoom In">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;zoom&quot;, 0.1)">
                      <span class="fa fa-search-plus"></span>
                    </span>
                  </div>
                  <div class="navBt" data-method="zoom" data-option="-0.1" title="Zoom Out">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;zoom&quot;, -0.1)">
                      <span class="fa fa-search-minus"></span>
                    </span>
                  </div>
                </div>

                <div class="navGroup">
                  <div class="navBt" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;move&quot;, -10, 0)">
                      <span class="fa fa-arrow-left"></span>
                    </span>
                  </div>
                  <div class="navBt" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;move&quot;, 10, 0)">
                      <span class="fa fa-arrow-right"></span>
                    </span>
                  </div>
                  <div class="navBt" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;move&quot;, 0, -10)">
                      <span class="fa fa-arrow-up"></span>
                    </span>
                  </div>
                  <div class="navBt" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;move&quot;, 0, 10)">
                      <span class="fa fa-arrow-down"></span>
                    </span>
                  </div>
                </div>

                <div class="navGroup">
                  <div class="navBt" data-method="rotate" data-option="-45" title="Rotate Left">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;rotate&quot;, -45)">
                      <span class="fa fa-rotate-left"></span>
                    </span>
                  </div>
                  <div class="navBt" data-method="rotate" data-option="45" title="Rotate Right">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;rotate&quot;, 45)">
                      <span class="fa fa-rotate-right"></span>
                    </span>
                  </div>
                </div>

                <div class="navGroup">
                  <div class="navBt" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;scaleX&quot;, -1)">
                      <span class="fa fa-arrows-h"></span>
                    </span>
                  </div>
                  <div class="navBt" data-method="scaleY" data-option="-1" title="Flip Vertical">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;scaleY&quot;, -1)">
                      <span class="fa fa-arrows-v"></span>
                    </span>
                  </div>
                </div>

                <div class="navGroup">
                  <div class="navBt" data-method="crop" title="Crop">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;crop&quot;)">
                      <span class="fa fa-check"></span>
                    </span>
                  </div>
                  <div class="navBt" data-method="clear" title="Clear">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;clear&quot;)">
                      <span class="fa fa-remove"></span>
                    </span>
                  </div>
                </div>

                <div class="navGroup">
                  <div class="navBt" data-method="disable" title="Disable">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;disable&quot;)">
                      <span class="fa fa-lock"></span>
                    </span>
                  </div>
                  <div class="navBt" data-method="enable" title="Enable">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;enable&quot;)">
                      <span class="fa fa-unlock"></span>
                    </span>
                  </div>
                </div>

                <div class="navGroup">
                  <div class="navBt" data-method="reset" title="Reset">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;reset&quot;)">
                      <span class="fa fa-refresh"></span>
                    </span>
                  </div>
                  <label class="navBt btn-upload" for="inputImage" title="Upload image file">
                    <input type="file" class="sr-only" id="inputImage" name="file"
                      accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="Import image with Blob URLs">
                      <span class="fa fa-upload"></span>
                    </span>
                  </label>
                  <div class="navBt" data-method="destroy" title="Destroy">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;destroy&quot;)">
                      <span class="fa fa-power-off"></span>
                    </span>
                  </div>
                </div>

                <div class="navGroup btn-group-crop">
                  <div class="btn btn-success" data-method="getCroppedCanvas"
                    data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;getCroppedCanvas&quot;, { maxWidth: 4096, maxHeight: 4096 })">
                      Get Cropped Canvas
                    </span>
                  </div>
                  <div class="btn btn-success" data-method="getCroppedCanvas"
                    data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 160, height: 90 })">
                      160&times;90
                    </span>
                  </div>
                  <div class="btn btn-success" data-method="getCroppedCanvas"
                    data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                      title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 320, height: 180 })">
                      320&times;180
                    </span>
                  </div>
                </div>

                <!-- Show the cropped image in modal -->
                <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true"
                  aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body"></div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a class="btn btn-primary" id="download" href="javascript:void(0);"
                          download="cropped.jpg">Download</a>
                      </div>
                    </div>
                  </div>
                </div><!-- /.modal -->
              </div><!-- /.docs-buttons -->
              <div class="photosContent">
                <div class="cropperCover">
                  <div class="img-container">
                    <img id="cropperimage" src="" alt="Picture">
                  </div>
                </div>
                <!-- 下面列表 -->
              </div>
            </div>
            <div class="photosInfor">
              <!-- <h3>Preview:</h3> -->
              <div class="docs-preview clearfix">
                <div class="img-preview preview-md"></div>
              </div>

              <!-- <h3>Data:</h3> -->
              <div class="docs-data">
                <div class="input-group input-group-sm">
                  <span class="input-group-prepend">
                    <label class="input-group-text" for="dataX">X</label>
                  </span>
                  <input type="text" class="form-control" id="dataX" placeholder="x">
                  <span class="input-group-append">
                    <span class="input-group-text">px</span>
                  </span>
                </div>
                <div class="input-group input-group-sm">
                  <span class="input-group-prepend">
                    <label class="input-group-text" for="dataY">Y</label>
                  </span>
                  <input type="text" class="form-control" id="dataY" placeholder="y">
                  <span class="input-group-append">
                    <span class="input-group-text">px</span>
                  </span>
                </div>
                <div class="input-group input-group-sm">
                  <span class="input-group-prepend">
                    <label class="input-group-text" for="dataWidth">Width</label>
                  </span>
                  <input type="text" class="form-control" id="dataWidth" placeholder="width">
                  <span class="input-group-append">
                    <span class="input-group-text">px</span>
                  </span>
                </div>
                <div class="input-group input-group-sm">
                  <span class="input-group-prepend">
                    <label class="input-group-text" for="dataHeight">Height</label>
                  </span>
                  <input type="text" class="form-control" id="dataHeight" placeholder="height">
                  <span class="input-group-append">
                    <span class="input-group-text">px</span>
                  </span>
                </div>
                <div class="input-group input-group-sm">
                  <span class="input-group-prepend">
                    <label class="input-group-text" for="dataRotate">Rotate</label>
                  </span>
                  <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                  <span class="input-group-append">
                    <span class="input-group-text">deg</span>
                  </span>
                </div>
                <div class="input-group input-group-sm">
                  <span class="input-group-prepend">
                    <label class="input-group-text" for="dataScaleX">ScaleX</label>
                  </span>
                  <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                </div>
                <div class="input-group input-group-sm">
                  <span class="input-group-prepend">
                    <label class="input-group-text" for="dataScaleY">ScaleY</label>
                  </span>
                  <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                </div>
              </div>
              <div class="Edit"></div>
            </div>
          </div>
          <!-- 右邊 PAGE CONTENT -->
        </div>
      </div>
      <!-- 內容 CONTENT -->
    </div>
  </div>

  @section('script')
  <script type="text/javascript">
    window.onload = function () {

      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML +=
          '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
    }
  </script>

  @stop

  @section('script_back')
  <!--  2019/09/08  cropperjs-master -->
    <script src="{{ asset('vender/assets/js/custom/cropperjs-master/cropper.js') }}"></script>
    <script src="{{ asset('vender/assets/js/custom/cropperjs-master/main.js') }}"></script>

    <!--============  Fantasy JS  ============-->
    <script type="text/javascript" src="{{ asset('vender/assets/js/custom/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vender/assets/js/custom/js_builder.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vender/assets/js/custom/photos.js') }}"></script>
  @stop
@stop