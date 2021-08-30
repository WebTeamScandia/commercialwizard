<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?= isset($meta_title) ? $meta_title : "Wizard Calculator" ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  </head>
  <style>
    ul {
      list-style-type:none;
      padding:0;
      margin:0
    }
    .pw_prompt {
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      text-align: center;
      background: #F1F2F4;
      position:fixed;
      left: 50%;
      top:50%;
      margin-left:-100px;
      padding:20px;
      width:250px;
      box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
      border-radius: 5px;
    }
    .pw_prompt label {
      display:block; 
      margin-bottom:5px;
    }
    .pw_prompt input {
      border: 1px solid grey;
      border-radius: 3px;
      margin-bottom:10px;
    }
    .form-detail {
      background: rgba(239,239,239,0.5);
      box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
      padding: 15px 30px;
      border-radius: 10px;
    }
    .form-detail-title {
      color: #EFEFEF;
      text-align: center;
      background-color: #00aeef;
      padding: 5px;
      width: 250px;
      position: relative;
      top: -30px;
      box-shadow: 0px 0px 5px 1px rgba(0, 174, 239, 0.37);
      border-radius: 3px;
    }

    .submit-container {
      position:fixed; 
      bottom:0;
      width: 100%;
      left: 0;
      padding: 20px 0px 40px 0px;
      text-align: center;
      background: rgba(0,0,0,0.6);
    }
  </style>
  <nav class="navbar navbar-dark bg-dark mb-5">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="<?= base_url();?>/public/assets/img/am-finn-logo-white.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
        AM-FINN SAUNA AND STEAM WIZARD CALCULATOR
      </a>
      <form action="<?= base_url();?>/index.php/home/admin_panel" method="get" id="admin-form">
        <button class="btn btn-dark" type="button" onmousedown="inputAccessCode()">Admin Panel</button>
      </form>
    </div>
  </nav>
  <body style="background: grey">
    <div class="container">
      <?= $this->renderSection('content') ?>
    </div>
</body>
</html>
<script>
    function inputAccessCode() {
        var promptCount = 0;
        window.pw_prompt = function(options) {
            var lm = options.lm || "Password:",
            bm = options.bm || "Submit";
            if(!options.callback) { 
                alert("No callback function provided! Please provide one.") 
            };

            var prompt = document.createElement("div");
            prompt.className = "pw_prompt";

            var submit = function() {
                options.callback(input.value);
                document.body.removeChild(prompt);
            };

            var label = document.createElement("label");
            label.textContent = lm;
            label.for = "pw_prompt_input" + (++promptCount);
            prompt.appendChild(label);

            var input = document.createElement("input");
            input.id = "pw_prompt_input" + (promptCount);
            input.type = "password";
            input.addEventListener("keyup", function(e) {
                if (e.keyCode == 13) submit();
            }, false);
            prompt.appendChild(input);

            var button = document.createElement("button");
            button.className = "btn btn-secondary";
            button.textContent = bm;
            button.addEventListener("click", submit, false);
            prompt.appendChild(button);

            document.body.appendChild(prompt);
        };

        pw_prompt({
            lm:"Please enter the passcode:", 
            callback: function(password) {
                if(password == "get PW from somewhere safe") {
                    document.getElementById("admin-form").submit();
                }
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>