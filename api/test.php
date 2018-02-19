<?php
require '../wp-config.php';

function getInspectionTypeByOrdertypetest($data=null,$ordertype=null){
    echo 'sdfjsdfj';
        $url= ISN_API.'ordertypes?username='.$data['username'].'&password='.$data['password'];
        $results=getContentFromUrl($url);
        $inspectionName='';
        if(!empty($results['ordertypes'])){
            foreach($results['ordertypes'] as $k=>$v){
               
               if($v['id']==$ordertype){
                $inspectionName=str_replace(PHP_EOL, '', $v['name']);
                $inspectionName = preg_replace("/[\n\r]/","",$inspectionName); 
              }  
            }
        }
    $inspectionName=str_replace(' ','-',strtolower($inspectionName));
    $test=json_decode(file_get_contents(site_url().'/api/getAllInspectionTypes.php?userId=11'),true);
    if(!empty($test['result'])){
      foreach($test['result'] as $ka=>$va){
        $va['name']=str_replace(' ','-',strtolower($va['name']));
        if(strtolower($inspectionName)==strtolower($va['name'])){
            return $va['type'];
            break;
        }
      }  
    }
    
       
}


$data=getOwnerDetails();
$testing=getInspectionTypeByOrdertypetest($data,'cb3bc23f-e87b-46b9-a80f-24ca833f5002');
echo $testing;
pr($testing);
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
	"hvacSystemVisual": "",
	"outdoorRh": "",
	"inspectionDate": "",
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
	"inspectionTime": "",
	"areaDetails": [{
    	"areaId":"",
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
        	"sampleId":"",
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
            "sampleId":"",
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























$data = array(
    'datetime' => '2018-02-14 04:00:30',
    'inprogress' => '0',
    'scheduled' => '2018-02-14 04:00:30',
    'address1' => 'test',
    'address2' => 'test',
    'city' => 'test',
    'state' => 'test',
    'zip' => 'test',
    'latitude' => 'test',
    'longitude' => 'test',
    'duration' => 'test',
    'squarefeet' => 'test',
    'yearbuilt' => 'test',
    'reportnumber' => '1231adasdas',
    'salesprice' => 'test',
    'ordertype' => 'test',
    'clientuuid' => 'baeeb0a6-71a6-48bd-8a5e-4049a0ff5089',
    'buyersagentuuid' => '',
    'sellersagentuuid' => '',
    'inspector1uuid' => 'd734a00a-1bb1-477b-bf16-bd7e165f3c1d',
    'fees' => '10'
);
$handle = curl_init('https://goisn.net/moldexpert/rest/order?username=imark&password=1121$sahil$');
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
$resp=curl_exec($handle);

curl_close($handle);
echo '<pre>';
print_r($resp);
die;



/* Add A clint*/

echo '{
	"userId": "9",
	"clientId": "4",
	"rehabbedAfterYear":"yes",
    "inspectionType":"asdas",
    "paymentType":"sadas",
    "inspectionDate":"15 Feb,2018",
    "inspectionTime":"11:23 PM",
    "isnNotes":"",
    "insuaranceCompany":"asdas",
    "policyNumber":"asdas",
    "claim":"asdas",
    "insuaranceAdjuster":"asd",
    "claimCount":"asd",
    "dateOfLoss":"15 Feb,2018",
    "typeOfLoss":"asdsad",
    "remedeationCompany":"asdas",
    "publicAdjuster":"asdas",
    "referralSource":"asd"
}';
die;


$data = array('firstname' => 'Ross', 'lastname' => 'test');
/*https://goisn.net/moldexpert/rest/client?username=imark&password=1121$sahil$&firstname=&lastname&displayname&emailaddress&address1&address2&city&state (abbreviation or name)&zip&workphone&homephone&mobilephone&workfax&homefax*/
$handle = curl_init('https://goisn.net/moldexpert/rest/client?username=imark&password=1121$sahil$');
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
$resp=curl_exec($handle);

curl_close($handle);
echo '<pre>';
print_r($resp);
die;

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