<?php

const TOKEN = '6890323856:AAEFic41EgpeSFvT1W5IcnrTLLmMcN2AZm0';
const CHATID = '-1002028547482';

$types = array('image/gif', 'image/png', 'image/jpeg', 'application/pdf');


$size = 1073741824;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$fileSendStatus = '';
	$textSendStatus = '';
	$msgs = [];

	/*echo "<pre>";
	print_r(json_encode($_POST));
	echo "</pre>";
	return;*/

	if (!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['link'])) {

		$txt = "";

		if (isset($_POST['link']) && !empty($_POST['link'])) {
				$txt .= "Товар: " . strip_tags(trim(urlencode($_POST['link']))) . "%0A";
		}

		// Ім'я
		if (isset($_POST['name']) && !empty($_POST['name'])) {
			$txt .= "Ім'я: " . strip_tags(trim(urlencode($_POST['name']))) . "%0A";
		}

		// Номер телефона
		if (isset($_POST['phone']) && !empty($_POST['phone'])) {
			$txt .= "Телефон: " . strip_tags(trim(urlencode($_POST['phone']))) . "%0A";
		}

		$url = 'https://api.telegram.org/bot' . TOKEN . '/sendMessage?chat_id=' . CHATID . '&parse_mode=html&text=' . $txt;

		$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/log.txt', 'a');
		fwrite($file, date('Y-m-d G:i:s') . ' - ' . print_r($url, true) . "\n");
		fclose($file);

		$textSendStatus = @file_get_contents($url);
		$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/log.txt', 'a');
		fwrite($file, date('Y-m-d G:i:s') . ' - ' . print_r(json_decode($textSendStatus), true) . "\n");
		fclose($file);

		if (isset(json_decode($textSendStatus)->{'ok'}) && json_decode($textSendStatus)->{'ok'}) {
			if (!empty($_FILES['files']['tmp_name'])) {

				$urlFile =  "https://api.telegram.org/bot" . TOKEN . "/sendMediaGroup";

				$path = $_SERVER['DOCUMENT_ROOT'] . '/telegramform/tmp/';

				$mediaData = [];
				$postContent = [
					'chat_id' => CHATID,
				];

				for ($ct = 0; $ct < count($_FILES['files']['tmp_name']); $ct++) {
					if ($_FILES['files']['name'][$ct] && @copy($_FILES['files']['tmp_name'][$ct], $path . $_FILES['files']['name'][$ct])) {
						if ($_FILES['files']['size'][$ct] < $size && in_array($_FILES['files']['type'][$ct], $types)) {
							$filePath = $path . $_FILES['files']['name'][$ct];
							$postContent[$_FILES['files']['name'][$ct]] = new CURLFile(realpath($filePath));
							$mediaData[] = ['type' => 'document', 'media' => 'attach://' . $_FILES['files']['name'][$ct]];
						}
					}
				}

				$postContent['media'] = json_encode($mediaData);

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
				curl_setopt($curl, CURLOPT_URL, $urlFile);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $postContent);
				$fileSendStatus = curl_exec($curl);
				curl_close($curl);
				$files = glob($path . '*');
				foreach ($files as $file) {
					if (is_file($file))
						unlink($file);
				}
			}
			echo json_encode('SUCCESS');
		} else {
			echo json_encode('ERR');
		}
	} else {
		echo json_encode('NOTVALID');
	}
} else {
	//header("Location: /");
	echo json_encode('REQUEST_METHOD Error');
}
