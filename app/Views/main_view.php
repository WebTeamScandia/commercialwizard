<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<form action="" method="post" style="padding-bottom:80px">
  <div class="row">
    <div class="col">
      <div class="form-detail mb-5" style="padding-bottom:22px">
        <div class="form-detail-title">
          <h6>Project Information</h6>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="zoho-id" class="form-label">Zoho Proposal Id: </label>
            <select class="form-select" name="zoho-id" id="zoho-id">
              <option value="0">Select Deals</option>
            </select>
          </div>
          <div class="col">
            <label for="proposal-date" class="form-label">Date: </label>
            <input type="textbox" class="form-control" readonly value="<?php echo date("M j, Y", time()); ?>" name="date">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="prj-name" class="form-label">Project name:</label>
            <input type="text" class="form-control" name="prj-name" id="prj-name">
          </div>
          <div class="col">
            <label for="prj-address" class="form-label">Shipping Address:</label>
            <input type="text" class="form-control" name="prj-address" id="prj-address">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="prj-zip" class="form-label">Zip code:</label>
            <input type="text" class="form-control" name="prj-zip" id="prj-zip">
          </div>
          <div class="col">
            <label for="prj-author" class="form-label">Author:</label>
            <input type="text" class="form-control" name="prj-author" id="prj-author">
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="form-detail mb-5">
        <div class="form-detail-title">
          <h6>Discount and Sales Tax</h6>
        </div>
        <div class="container-sm">
          <div class="row mb-3">
            <label for="discount" class="control-label col-sm-8">Discount (%)</label>
            <div class="col-sm-4">
              <input type="number" class="form-control" name="discount" id="discount" style="width: 58px">
            </div>
          </div>
          <div class="row mb-3">
            <label for="tax" class="control-label col-sm-8">Sales tax (%) </label>
            <div class="col-sm-4">
              <input type="number" class="form-control" name="tax" id="tax" style="width: 58px">
            </div>
          </div>      
        </div>
      </div>
      
      <div class="form-detail mb-3">
        <div class="form-detail-title">
          <h6>Proposal Room Types</h6>
        </div>
        <div class="container mb-3" >
          <div class="row">
            <div class="col">
              <div class="form-check form-switch">
                <label for="sauna" class="form-check-label">Sauna Rooms</label>
                <input type="checkbox" class="form-check-input" name="sauna" id="sauna" onclick="showSaunaConfigsTable()">
              </div>
            </div>
            <div class="col">
              <div class="form-check form-switch">
                <label for="steam" class="form-check-label">Steam Rooms</label>
                <input type="checkbox" class="form-check-input" name="steam" id="steam" onclick="showSteamConfigsTable()">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="mb-3" id="saunas-config-table" style="display:none;">
    <div class="row mb-5">
      <div class="col-sm-3"></div>
      <div class="col">
        <div class="form-detail">
          <div class="form-detail-title">
            <h6>Sauna Rooms Configurations</h6>
          </div>
          <div class="form-check form-switch mb-4">
            <div class="row mb-2">
              <label for="sauna-same-dims" class="form-check-label col-sm-9">Dimensions for all sauna rooms are the same</label>
              <input type="checkbox" class="form-check-input col-sm-1" name="sauna-same-dims" id="sauna-same-dims">
            </div>
            <div class="row mb-2">
              <label for="sauna-same-heater" class="form-check-label col-sm-9">Heater type for all sauna rooms is the same</label>
              <input type="checkbox" class="form-check-input col-sm-1" name="sauna-same-heater" id="sauna-same-heater">
            </div>
            <div class="row mb-2">
              <label for="sauna-same-accessories" class="form-check-label col-sm-9">Accessories for all sauna rooms are the same</label>
              <input type="checkbox" class="form-check-input col-sm-1" name="sauna-same-accessories" id="sauna-same-accessories">
            </div>
          </div>
          <div class="row mb-3">
            <label for="num-saunas" class="control-label col">Quantity of Saunas:</label>
            <div class="col">
              <input type="number" class="form-control" name="num-saunas" id="num-saunas" onblur="showSaunasForms()">
            </div>
          </div>
          <div class="row mb-3">
            <label for="saunas-shipping" class="control-label col">Shipping cost of one sauna room:</label>
            <div class="col">
              <input type="number" class="form-control" name="saunas-shipping" id="saunas-shipping">
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-3"></div>
    </div>
  </div>
  
  <div class="mb-3" id="steams-config-table" style="display:none;">
    <div class="row mb-5">
      <div class="col-sm-3"></div>
      <div class="col">
        <div class="form-detail">
          <div class="form-detail-title">
            <h6>Steam Rooms Configurations</h6>
          </div>
          <div class="form-check form-switch mb-4">
            <div class="row mb-2">
              <label for="steam-same-dims" class="form-check-label col-sm-9">Dimensions for all steam rooms are the same</label>
              <input type="checkbox" class="form-check-input col-sm-1" name="steam-same-dims" id="steam-same-dims">
            </div>
            <div class="row mb-2">
              <label for="steam-same-heater" class="form-check-label col-sm-9">Heater type for all steam rooms is the same</label>
              <input type="checkbox" class="form-check-input col-sm-1" name="steam-same-heater" id="steam-same-heater">
            </div>
            <div class="row mb-2">
              <label for="steam-same-accessories" class="form-check-label col-sm-9">Accessories for all steam rooms are the same</label>
              <input type="checkbox" class="form-check-input col-sm-1" name="steam-same-accessories" id="steam-same-accessories">
            </div>
          </div>
          <div class="row mb-3">
            <label for="num-steams" class="control-label col">Quantity of steams:</label>
            <div class="col">
              <input type="number" class="form-control" name="num-steams" id="num-steams" onblur="showSteamForms()">
            </div>
          </div>
          <div class="row mb-3">
            <label for="steams-shipping" class="control-label col">Shipping cost of one steam room:</label>
            <div class="col">
              <input type="number" class="form-control" name="steams-shipping" id="steams-shipping">
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-3"></div>
    </div>
  </div>

  <div class="saunas-forms">
    <ul class="mb-5" id="saunas-dims" style="display:none">
      <li>
        <?= view("components/sauna_measurements")?>
      </li>
    </ul>
    <ul class="mb-5" id="saunas-heaters" style="display:none">
      <li>
        <?= view("components/sauna_heater")?>
      </li>
    </ul>
    <ul class="mb-5" id="saunas-accessories" style="display:none">
      <li>
        <?= view("components/sauna_accessories")?>
      </li>
    </ul>
  </div>
  
  <div class="submit-container">
    <input class="btn btn-light" type="submit" value="Get proposal">
  </div>
</form>


<script> 
  function showSaunaConfigsTable() {
    var configsTable = document.getElementById("saunas-config-table");
   
    if(document.getElementById("sauna").checked == true) {
      configsTable.style.display = "block";
    }
    else {
      configsTable.style.display = "none";
    }
  }

  function showSteamConfigsTable() {
    var configsTable = document.getElementById("steams-config-table");
   
    if(document.getElementById("steam").checked == true) {
      configsTable.style.display = "block";
    }
    else {
      configsTable.style.display = "none";
    }
  }

  function showSaunasForms() {
    if(document.getElementById("sauna-same-dims").checked == false) {
      showSaunasDims();
    }
    else {
      document.getElementById("sauna-dims").style.display = "block";
    }

    if(document.getElementById("sauna-same-heater").checked == false) {
      showSaunasHeater();
    }
    else {
      document.getElementById("sauna-heater").style.display = "block";
    }

    if(document.getElementById("sauna-same-accessories").checked == false) {
      showSaunasAccessories();
    }
    else {
      document.getElementById("sauna-accessories").style.display = "block";
    }
  }

  function showSaunasDims(){
    formsContainer = document.getElementById("saunas-dims");
    numSaunas = document.getElementById("num-saunas").value;
    qtyOfCurrentForms = formsContainer.getElementsByTagName("li").length;
    if(qtyOfCurrentForms < numSaunas) {
      missingForms = numSaunas - qtyOfCurrentForms;
      for(i=0; i<missingForms; i++) {
        child = formsContainer.lastChild;
        clone = child.cloneNode(true);
        clone.id = i;
        console.log(clone);
        formsContainer.append(clone);
      }
    }
    else if(qtyOfCurrentForms > numSaunas) {
      excessForms = qtyOfCurrentForms - numSaunas;
      for(i=0; i<excessForms; i++) {
        child = formsContainer.lastChild;
        formsContainer.removeChild(child);
      }
    }
    formsContainer.style.display = "block";
    return false;
  }

  function showSaunasHeater() {
    formsContainer = document.getElementById("saunas-heaters");
    numSaunas = document.getElementById("num-saunas").value;
    qtyOfCurrentForms = formsContainer.getElementsByTagName("li").length;
    if(qtyOfCurrentForms < numSaunas) {
      missingForms = numSaunas - qtyOfCurrentForms;
      for(i=0; i<missingForms; i++) {
        child = formsContainer.lastChild;
        clone = child.cloneNode(true);
        clone.id = i;
        console.log(clone);
        formsContainer.append(clone);
      }
    }
    else if(qtyOfCurrentForms > numSaunas) {
      excessForms = qtyOfCurrentForms - numSaunas;
      for(i=0; i<excessForms; i++) {
        child = formsContainer.lastChild;
        formsContainer.removeChild(child);
      }
    }
    formsContainer.style.display = "block";
    return false;
  }

  function showSaunasAccessories() {
    formsContainer = document.getElementById("saunas-accessories");
    numSaunas = document.getElementById("num-saunas").value;
    qtyOfCurrentForms = formsContainer.getElementsByTagName("li").length;
    if(qtyOfCurrentForms < numSaunas) {
      missingForms = numSaunas - qtyOfCurrentForms;
      for(i=0; i<missingForms; i++) {
        child = formsContainer.lastChild;
        clone = child.cloneNode(true);
        clone.id = i;
        console.log(clone);
        formsContainer.append(clone);
      }
    }
    else if(qtyOfCurrentForms > numSaunas) {
      excessForms = qtyOfCurrentForms - numSaunas;
      for(i=0; i<excessForms; i++) {
        child = formsContainer.lastChild;
        formsContainer.removeChild(child);
      }
    }
    formsContainer.style.display = "block";
    return false;
  }

</script>

<?= $this->endSection() ?>