<!DOCTYPE html>
<html>
<head>
  <title></title>
    <link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-select/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/font-awesome/css/font-awesome.min.css">

  <style type="text/css">
html {
  height: 100%;
}

body {
  background-color: #2590EB;
  height: 100%;
}

.wrapper {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.wrapper .file-upload {
  height: 200px;
  width: 200px;
  border-radius: 100px;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 4px solid #FFFFFF;
  overflow: hidden;
  background-image: linear-gradient(to bottom, #2590EB 50%, #FFFFFF 50%);
  background-size: 100% 200%;
  transition: all 1s;
  color: #FFFFFF;
  font-size: 100px;
}
.wrapper .file-upload input[type='file'] {
  height: 200px;
  width: 200px;
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  cursor: pointer;
}
.wrapper .file-upload:hover {
  background-position: 0 -100%;
  color: #2590EB;
}

</style>
</head>
<body>
  <div class="col-md-4">
    <div class="wrapper">
      <div class="file-upload">
        <input type="file"/>
        <i class="fa fa-arrow-up"></i>
      </div>
    </div>
  </div>
  
</body>
</html>