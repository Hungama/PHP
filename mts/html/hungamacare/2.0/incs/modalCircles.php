<table class="table table-condensed" style="font-size: 10px">
   <thead> <tr class="info"><td  colspan="4" valign="bottom" >North 1</td></tr></thead>
  <tr>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Jammu-Kashmir" <?php if($_REQUEST['Circle']) {echo in_array('Jammu-Kashmir',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Jammu-Kashmir",$AR_CList)) {echo "disabled";}?> />
    JK</td>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Himachal Pradesh" <?php if($_REQUEST['Circle']) {echo in_array('Himachal Pradesh',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Himachal Pradesh",$AR_CList)) {echo "disabled";}?> />
    HP</td>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Punjab" <?php if($_REQUEST['Circle']) {echo in_array('Punjab',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Punjab",$AR_CList)) {echo "disabled";}?> />
    Punjab</td>
    <td><input class="circle" name="Circle[]" type="checkbox" value="Rajasthan" <?php if($_REQUEST['Circle']) {echo in_array('Rajasthan',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Rajasthan",$AR_CList)) {echo "disabled";}?> />
RJ</td>
  </tr>
  <tr>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Haryana" <?php if($_REQUEST['Circle']) {echo in_array('Haryana',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Haryana",$AR_CList)) {echo "disabled";}?> />
    HAR</td>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Delhi" <?php if($_REQUEST['Circle']) {echo in_array('Delhi',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Delhi",$AR_CList)) {echo "disabled";}?> />
    Delhi</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <thead>
    <th  colspan="4" valign="bottom" >East</th>
    </thead>
  <tr>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="UP WEST" <?php if($_REQUEST['Circle']) {echo in_array('UP WEST',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("UP WEST",$AR_CList)) {echo "disabled";}?> />
    UPW</td>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="UP EAST" <?php if($_REQUEST['Circle']) {echo in_array('UP EAST',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("UP EAST",$AR_CList)) {echo "disabled";}?> />
    UPE</td>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Bihar" <?php if($_REQUEST['Circle']) {echo in_array('Bihar',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Bihar",$AR_CList)) {echo "disabled";}?> />
    Bihar</td>
    <td><input class="circle" name="Circle[]" type="checkbox" value="Assam" <?php if($_REQUEST['Circle']) {echo in_array('Assam',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Assam",$AR_CList)) {echo "disabled";}?> />
Assam</td>
    
    
  </tr>
  <tr>
    <td>
<input class="circle" name="Circle[]" type="checkbox" value="WestBengal" <?php if($_REQUEST['Circle']) {echo in_array('WestBengal',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("WestBengal",$AR_CList)) {echo "disabled";}?>  />
WB</td>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Kolkata" <?php if($_REQUEST['Circle']) {echo in_array('Kolkata',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Kolkata",$AR_CList)) {echo "disabled";}?> />
    KOL</td>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Orissa" <?php if($_REQUEST['Circle']) {echo in_array('Orissa',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Orissa",$AR_CList)) {echo "disabled";}?> />
    Orissa</td>
    <td><input class="circle" name="Circle[]" type="checkbox" value="NE" <?php if($_REQUEST['Circle']) {echo in_array('NE',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("NE",$AR_CList)) {echo "disabled";}?> />
NE</td>
  </tr>
   <thead>
    <th  colspan="4" valign="bottom" >West</th>
    </thead>
  <tr>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Gujarat" <?php if($_REQUEST['Circle']) {echo in_array('Gujarat',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Gujarat",$AR_CList)) {echo "disabled";}?> />
    Gujarat</td>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Madhya Pradesh" <?php if($_REQUEST['Circle']) {echo in_array('Madhya Pradesh',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Madhya Pradesh",$AR_CList)) {echo "disabled";}?> />
    MP</td>
    <td><input class="circle" name="Circle[]" type="checkbox" value="Maharashtra" <?php if($_REQUEST['Circle']) {echo in_array('Maharashtra',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Maharashtra",$AR_CList)) {echo "disabled";}?> />
    MH</td>
    <td><input class="circle" name="Circle[]" type="checkbox" value="Mumbai" <?php if($_REQUEST['Circle']) {echo in_array('Mumbai',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Mumbai",$AR_CList)) {echo "disabled";}?> />
Mumbai </td>
  </tr>
   <thead>
    <th  colspan="4" valign="bottom" >South</th>
    </thead>
  <tr>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Andhra Pradesh" <?php if($_REQUEST['Circle']) {echo in_array('Andhra Pradesh',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Andhra Pradesh",$AR_CList)) {echo "disabled";}?> />
      AP</td>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Karnataka" <?php if($_REQUEST['Circle']) {echo in_array('Karnataka',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Karnataka",$AR_CList)) {echo "disabled";}?> />
      KK</td>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Chennai" <?php if($_REQUEST['Circle']) {echo in_array('Chennai',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Chennai",$AR_CList)) {echo "disabled";}?> />
      Chennai</td>
    <td><input class="circle" name="Circle[]" type="checkbox" value="Kerala" <?php if($_REQUEST['Circle']) {echo in_array('Kerala',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Kerala",$AR_CList)) {echo "disabled";}?> />
Kerala</td>
  </tr>
  <tr>
    <td>
      <input class="circle" name="Circle[]" type="checkbox" value="Tamil Nadu" <?php if($_REQUEST['Circle']) {echo in_array('Tamil Nadu',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Tamil Nadu",$AR_CList)) {echo "disabled";}?> />
      TN</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <thead>
    <th  colspan="4" valign="bottom" >International</th>
    </thead>
  <tr>
    <td><input class="circle" name="Circle[]" type="checkbox" value="Indian" <?php if($_REQUEST['Circle']) {echo in_array('Indian',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Indian",$AR_CList)) {echo "disabled";}?> />
      Indian</td>
    <td><input class="circle" name="Circle[]" type="checkbox" value="Nepali" <?php if($_REQUEST['Circle']) {echo in_array('Nepali',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Nepali",$AR_CList)) {echo "disabled";}?> />
      Nepali</td>
    <td><input class="circle" name="Circle[]" type="checkbox" value="Bangla" <?php if($_REQUEST['Circle']) {echo in_array('Bangla',$_REQUEST['Circle']) ? 'checked':''  ;}?>  <?php if(!in_array("Bangla",$AR_CList)) {echo "disabled";}?> />
      Bangla</td>
    <td>&nbsp;</td>
  </tr>
  </table>