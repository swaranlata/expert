<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="submitAreaDetails" mehtod="post">
              <div class="modal-header">
                <h5 class="modal-title headingTitle" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="alert alert-success" style="display:none;">
                     <p class="responseArea"></p>
                    </div>
                 <input type="hidden" name="action"  value="save_area_popup_details">
                 <input type="hidden" name="areaId"  value="<?php echo @$_GET['areaId']; ?>">
                 <input type="hidden" name="type" id="addType"  value="">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label title"></label>
                     <div class="radio ">
                            <label><input type="radio" name="typeValue" value="yes">Yes</label>
                      </div>
                      <div class="radio ">
                            <label><input type="radio" name="typeValue" value="no">No</label>
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Observation/Recommendation/Measurements:</label>
                    <input type="text" class="form-control" name="measurements">
                  </div>
                  <div class="form-group">
                    <label for="message-text" class="col-form-label">Location:</label>
                     <select name="location" class="selectpicker">
                         <option value="north">North</option>
                         <option value="south">South</option>
                         <option value="east">East</option>
                         <option value="west">West</option>
                      </select>
                   </div>
                    <div class="form-group">
                         <input type="file" class="imgInp" name="typeImage"/>
                         <input type="hidden" name="image" id="typeImage" />
                         <img class="blah" style="display:none;" width="100px" src="#" alt="your image" />
                    </div>
                     <div class="form-group">
                        <input type="file"  class="drimgInp"  name="typeDiagram"/>
                        <input type="hidden" name="diagram" id="typeDiagram" />
                        <img class="drblah" style="display:none;" width="100px" src="#" alt="your image" />
                    </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary editDetails">Save</button>
      </div>
        </form>
    </div>
  </div>
</div>
