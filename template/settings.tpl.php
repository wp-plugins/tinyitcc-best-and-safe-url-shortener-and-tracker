
<form method="post" action="./options-general.php?page=Tinyit_shorturl-settings" id="Tinyit_shorturl_settings" style="margin-top:2em;margin-left:1em;">

<table class="form-table">


  <tr valign="top">
    <th scope="row">
        <label for="ApiUrl" style="font-weight:bold;"><?php echo __('Tinyit.cc - Best and safe URL shortener and tracker') ?></label><br />
<?php echo __('Thank you for considering the best and safe URL shortening service on the internet. This plugin will automatically shorten the post\'s URL/Permalink and put the short link at the bottom of each post. Also supports posting your short link to Twitter.<br>
<b>About Tinyit.cc</b><br>
Convert long links to short tiny links, customize and share them instantly with your friends, get comprehensive click statistics for your short links and use free API in your applications. Each URL checked before redirecting against Google safe browsing list of websites, phishtank phishing list, spamming list, SURBL list and Tinyit.cc blocked websites list. More information <a href="http://tinyit.cc/more.html" target="_blank">here</a>.<br>
<b>Note:</b> You can also keep a track of your short URL\'s you create through API, through your tinyit.cc\'s user account.

<br><br><b>IMP:</b> Copy and Paste this in the texbox below after replacing with your tinyit.cc username and API key:<b> http://tinyit.cc/api.php?user=USERNAME&api=APIKEY&url=%s </b><br>Dont have an API key, get a new API Key from <a href="http://tinyit.cc/getapi.html" target="_blank">here.</a>') ?><br /><br />
    </th>
  </tr>
  <tr>
    <td>
       <input type="text" name="ApiUrl" value="<?php echo $opt['ApiUrl'] ?>" style="width:550px;" /><br />
	    <p><?php echo __('Saved Settings:') ?></p>
          <select name="ApiUrlList" size="1" onchange="this.form.ApiUrl.value = this.form.ApiUrlList.value;">
            <?php foreach ($apiUrls as $item): ?>
              <option value="<?php echo $item['url'] ?>"><?php echo $item['name'] ?></option>
            <?php endforeach ?>
          </select>
    </td>
  </tr>

  <tr valign="top">
    <th scope="row">
        <label for="Display" style="font-weight:bold;"><?php echo __('Display the Short URL in your posts?') ?></label>
    </th>
  </tr>
  <tr>
    <td>
        <input type="radio" name="Display" value="Y" <?php echo $opt['Display'] == 'Y' ? 'checked="checked"' : '' ?> /> <?php echo __('Yes') ?>
        <input type="radio" name="Display" value="N" <?php echo $opt['Display'] == 'N' ? 'checked="checked"' : '' ?> /> <?php echo __('No') ?>
    </td>
	
  </tr>

  <tr valign="top">
    <th scope="row">
        <label for="TwitterLink" style="font-weight:bold;"><?php echo __('Display the Twitter Link in your posts?') ?></label>
    </th>
  </tr>
  <tr>
    <td>
        <input type="radio" name="TwitterLink" value="Y" <?php echo $opt['TwitterLink'] == 'Y' ? 'checked="checked"' : '' ?> /> <?php echo __('Yes') ?>
        <input type="radio" name="TwitterLink" value="N" <?php echo $opt['TwitterLink'] == 'N' ? 'checked="checked"' : '' ?> /> <?php echo __('No') ?>
    </td>
  </tr>
  
  <tr valign="top">
    <th scope="row">
        <input type="submit" name="save" value="<?php echo __('Save') ?>" />
    </th>
    <td>

    </td>
  <tr>

</table>


</form>
