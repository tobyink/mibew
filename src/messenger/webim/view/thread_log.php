<?php
/*
 * Copyright 2005-2013 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

$page['title'] = getlocal("thread.chat_log");

function tpl_header() { global $page, $webimroot, $jsver; ?>
<script type="text/javascript" src="<?php echo($webimroot); ?>/js/<?php echo($jsver); ?>/common.js"></script>
<script type="text/javascript" src="<?php echo($webimroot); ?>/js/<?php echo($jsver); ?>/handlebars.js"></script>
<script type="text/javascript" src="<?php echo($webimroot); ?>/js/<?php echo($jsver); ?>/handlebars_helpers.js"></script>
<script type="text/javascript" src="<?php echo($webimroot); ?>/js/<?php echo($jsver); ?>/messageview.js"></script>
<script type="text/javascript" src="<?php echo($webimroot); ?>/js/templates/compiled/message.tpl.js"></script>
<script type="text/javascript"><!--
	EventHelper.register(window, 'onload', function() {
		var threadMessages = <?php echo($page['threadMessages']); ?>;
		var messageEl = document.getElementById('message');
		var messageView = new MessageView();
		for (var index in threadMessages) {
			if (! threadMessages.hasOwnProperty(index)) {
				continue;
			}
			messageEl.innerHTML += messageView.themeMessage(threadMessages[index]);
		}
	});
// --></script>
<?php }

function tpl_content() { global $page, $webimroot, $errors;
$chatthreadinfo = $page['thread_info'];
$chatthread = $page['thread_info']['thread'];
?>

<?php echo getlocal("thread.intro") ?>

<br/><br/>

<div class="logpane">
<div class="header">

		<div class="wlabel">
			<?php echo getlocal("page.analysis.search.head_name") ?>:
		</div> 
		<div class="wvalue">
			<?php echo topage(htmlspecialchars($chatthread->userName)) ?>
		</div>
		<br clear="all"/>
		
		<div class="wlabel">
			<?php echo getlocal("page.analysis.search.head_host") ?>:
		</div>
		<div class="wvalue">
			<?php echo get_user_addr(topage($chatthread->remote)) ?>
		</div>
		<br clear="all"/>

		<div class="wlabel">
			<?php echo getlocal("page.analysis.search.head_browser") ?>:
		</div>
		<div class="wvalue">
			<?php echo get_useragent_version(topage($chatthread->userAgent)) ?>
		</div>
		<br clear="all"/>

		<?php if( $chatthreadinfo['groupName'] ) { ?>
			<div class="wlabel">
				<?php echo getlocal("page.analysis.search.head_group") ?>:
			</div>
			<div class="wvalue">
				<?php echo topage(htmlspecialchars($chatthreadinfo['groupName'])) ?>
			</div>
			<br clear="all"/>
		<?php } ?>

		<?php if( $chatthread->agentName ) { ?>
			<div class="wlabel">
				<?php echo getlocal("page.analysis.search.head_operator") ?>:
			</div>
			<div class="wvalue">
				<?php echo topage(htmlspecialchars($chatthread->agentName)) ?>
			</div>
			<br clear="all"/>
		<?php } ?>

		<div class="wlabel">
			<?php echo getlocal("page.analysis.search.head_time") ?>:
		</div>
		<div class="wvalue">
			<?php echo date_diff_to_text($chatthread->modified-$chatthread->created) ?>
				(<?php echo date_to_text($chatthread->created) ?>)
		</div>
		<br clear="all"/>
</div>

<div class="message" id="message">
<?php 
	foreach( $page['threadMessages'] as $message ) {
		echo $message;
	}
?>
</div>
</div>

<br />
<a href="<?php echo $webimroot ?>/operator/history.php">
	<?php echo getlocal("thread.back_to_search") ?></a>
<br />


<?php 
} /* content */

require_once('inc_main.php');
?>