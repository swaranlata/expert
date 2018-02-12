<?php
echo date('Y-M-d',strtotime('20 Feb,2018'));
die;

echo '{
	"userId": "9",
	"inspectionId": "4",
	"outdoorTemprature": "tset",
	"enviormentType": "te",
	"hvacSystem": "asd",
	"hvacSystemValue": "asd",
	"bullets": "asd",
	"ductwork": "sad",
	"areaDetails": [{
		"areaName": "asd",
		"visualObservation": "ad",
		"sampleType": "sad",
		"serial": "asd",
		"generalObservation": "sd",
		"recommendations": "sd",
		"temprature": "asd",
		"rhRelativeHumidity": "asd",
		"images": [{
			"imageId": "",
			"key": "",
			"imageUrl": ""
		}],
		"diagram": [{
			"diagramId": "",
			"key": "",
			"diagram": ""
		}],
		"issueType": [{
			"typeId": "1",
			"type": "sdfsd",
			"typeValue": "sdfsd",
			"measurements": "sdfsd",
			"location": "sdf",
			"images": [{
				"imageId": "",
				"key": "",
				"imageUrl": ""
			}],
			"diagram": [{
				"diagramId": "",
				"key": "",
				"diagram": ""
			}]
		}, {
			"typeId": "2",
			"type": "sdfsd",
			"typeValue": "sdfsd",
			"measurements": "sdfsd",
			"location": "sdf",
			"images": [{
				"imageId": "",
				"key": "",
				"imageUrl": ""
			}],
			"diagram": [{
				"diagramId": "",
				"key": "",
				"diagram": ""
			}]
		}],
		"additionalSample": [{
			"sampleType": "test 1",
			"sampleSerialNo": "sdf",
			"sampleObservation": "sdfsd",
			"images": [{
				"imageId": "",
				"key": "",
				"imageUrl": ""
			}],
			"diagram": [{
				"diagramId": "",
				"key": "",
				"diagram": ""
			}]
		}, {
			"sampleType": "test 2",
			"sampleSerialNo": "sdf",
			"sampleObservation": "sdfsd",
			"images": [{
				"imageId": "",
				"key": "",
				"imageUrl": ""
			}],
			"diagram": [{
				"diagramId": "",
				"key": "",
				"diagram": ""
			}]
		}]
	}]
}';die;

?>