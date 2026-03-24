<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var \Bitrix\Bizproc\Activity\PropertiesDialog $dialog */

$map = $dialog->getMap();
$messageText = $map['MailText'];
$subject = $map['MailSubject'];
$messageType = $dialog->getCurrentValue($map['MailMessageType']['FieldName'], 'html');
$attachmentType = isset($map['FileType']) ? $map['FileType'] : null;
$attachment = isset($map['File']) ? $map['File'] : null;
$toEmail = isset($map['MailUserToEmail']) ? $map['MailUserToEmail'] : null;
$from = isset($map['MailUserFrom']) ? $map['MailUserFrom'] : null;

if ($from):?>
	<div class="bizproc-automation-popup-settings">
		<span class="bizproc-automation-popup-settings-title bizproc-automation-popup-settings-title-autocomplete">
			<?=htmlspecialcharsbx($from['Name'])?>:
		</span>
		<?=$dialog->renderFieldControl($from)?>
	</div>
<?
endif;
?>

	<div class="bizproc-automation-popup-settings">
		<span class="bizproc-automation-popup-settings-title bizproc-automation-popup-settings-title-autocomplete">
			<?=htmlspecialcharsbx($map['MailUserTo']['Name'])?>:
		</span>
		<?=$dialog->renderFieldControl($map['MailUserTo'])?>
	</div>
	<?php if ($toEmail): ?>
	<div class="bizproc-automation-popup-settings">
		<?=$dialog->renderFieldControl($toEmail)?>
	</div>
	<?php endif; ?>

	<div class="bizproc-automation-popup-settings">
		<?=$dialog->renderFieldControl($subject)?>
	</div>

	<div class="bizproc-automation-popup-settings" data-role="inline-selector-html">
		<div class="bizproc-automation-popup-select"><?php
			$emailEditor = new CHTMLEditor;

			$content = $dialog->getCurrentValue($messageText['FieldName'], '');
			if ($dialog->getCurrentValue('mail_message_encoded'))
			{
				$content = \CBPCustomMailActivity::decodeMailText($content);
				$content = \Bitrix\Bizproc\Automation\Helper::convertExpressions($content, $dialog->getDocumentType());
			}

			if ($messageType !== 'html')
			{
				$parser = new CTextParser();
				$content = $parser->convertText($content);
			}

			$emailEditor->show(array(
				'name'                => $messageText['FieldName'],
				'content'			  => $content,
				'siteId'              => SITE_ID,
				'width'               => '100%',
				'minBodyWidth'        => 630,
				'normalBodyWidth'     => 630,
				'height'              => 198,
				'minBodyHeight'       => 198,
				'showTaskbars'        => false,
				'showNodeNavi'        => false,
				'autoResize'          => true,
				'autoResizeOffset'    => 40,
				'bbCode'              => false,
				'saveOnBlur'          => false,
				'bAllowPhp'           => false,
				'limitPhpAccess'      => false,
				'setFocusAfterShow'   => false,
				'askBeforeUnloadPage' => true,
				'useFileDialogs' => false,
				'controlsMap'         => array(
					array('id' => 'Bold',  'compact' => true, 'sort' => 10),
					array('id' => 'Italic',  'compact' => true, 'sort' => 20),
					array('id' => 'Underline',  'compact' => true, 'sort' => 30),
					array('id' => 'Strikeout',  'compact' => true, 'sort' => 40),
					array('id' => 'RemoveFormat',  'compact' => true, 'sort' => 50),
					array('id' => 'Color',  'compact' => true, 'sort' => 60),
					array('id' => 'FontSelector',  'compact' => false, 'sort' => 70),
					array('id' => 'FontSize',  'compact' => false, 'sort' => 80),
					array('separator' => true, 'compact' => false, 'sort' => 90),
					array('id' => 'OrderedList',  'compact' => true, 'sort' => 100),
					array('id' => 'UnorderedList',  'compact' => true, 'sort' => 110),
					array('id' => 'AlignList', 'compact' => false, 'sort' => 120),
					array('separator' => true, 'compact' => false, 'sort' => 130),
					array('id' => 'InsertLink',  'compact' => true, 'sort' => 140),
					array('id' => 'InsertImage',  'compact' => false, 'sort' => 150),
					array('id' => 'InsertTable',  'compact' => false, 'sort' => 170),
					array('id' => 'Code',  'compact' => true, 'sort' => 180),
					array('id' => 'Quote',  'compact' => true, 'sort' => 190),
					array('separator' => true, 'compact' => false, 'sort' => 200),
					array('id' => 'Fullscreen',  'compact' => false, 'sort' => 210),
					array('id' => 'ChangeView',  'compact' => true, 'sort' => 220),
					array('id' => 'More',  'compact' => true, 'sort' => 400)
				),
			));
			?></div>
	</div>
	<input type="hidden" name="<?=htmlspecialcharsbx($map['MailMessageType']['FieldName'])?>" value="html">
	<input type="hidden" name="<?=htmlspecialcharsbx($map['MailCharset']['FieldName'])?>" value="<?=htmlspecialcharsbx(SITE_CHARSET)?>">
	<input type="hidden" name="<?=htmlspecialcharsbx($map['DirrectMail']['FieldName'])?>" value="Y">
	<input type="hidden" name="<?=htmlspecialcharsbx($map['MailSite']['FieldName'])?>" value="<?=htmlspecialcharsbx(SITE_ID)?>">
<?
$config = array(
	'type' => $dialog->getCurrentValue($attachmentType['FieldName']),
	'typeInputName' => $attachmentType['FieldName'],
	'valueInputName' => $attachment['FieldName'],
	'multiple' => $attachment['Multiple'],
	'required' => !empty($attachment['Required']),
	'useDisk' => CModule::IncludeModule('disk'),
	'label' => $attachment['Name'],
	'labelFile' => $attachmentType['Options']['file'],
	'labelDisk' => $attachmentType['Options']['disk']
);

if ($dialog->getCurrentValue($attachmentType['FieldName']) === 'disk')
{
	$config['selected'] = \Bitrix\Bizproc\Automation\Helper::prepareDiskAttachments(
		$dialog->getCurrentValue($attachment['FieldName'])
	);
}
else
{
	$config['selected'] = \Bitrix\Bizproc\Automation\Helper::prepareFileAttachments(
		$dialog->getDocumentType(),
		$dialog->getCurrentValue($attachment['FieldName'])
	);
}
$configAttributeValue = htmlspecialcharsbx(\Bitrix\Main\Web\Json::encode($config));
?>
	<div class="bizproc-automation-popup-settings" data-role="file-selector" data-config="<?=$configAttributeValue?>"></div>
