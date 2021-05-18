let mymap;

initialize();

  
function initialize() {
  mymap = L.map('mapid').setView([24.99, 121.57], 15);
  
  L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
      minZoom: 8, 
      maxZoom: 16
    }
  ).addTo(mymap);
  
  
  getParkinglots();
  getGatewayPos();
}

function getParkinglots() {
  fetch('https://data.taipei/api/v1/dataset/42694bb8-fc9d-4d82-af7a-0ad6f4c9ad57?scope=resourceAquire')
  .then(function(response) {
    return response.json();
  })
  .then(function(myJson) {
    
    for (let index = 0; index < myJson.result.results.length; index++) {
      
      let element = myJson.result.results[index];
      let lat = element["經度"];
      let lng = element["緯度"];
      let name = element["停車場名稱"];
      // {"停車場名稱":"捷運劍南路站轉乘停車場","_id":1,"項次":"1","經度":"121.5544513","緯度":"25.0845396"}
      console.log(lat, lng, name);
      addParkinglotMarker(lat, lng, name);
      
    }
    //非同步
    // console.log(parkinglots[1]);
  })
}

function addParkinglotMarker(lat, lng, name) {
  L.marker(
    [lng, lat], //注意順序
    {
      title: name,
    }
  ).addTo(mymap);
}

function getGatewayPos() {
  

  fetch('	https://data.taipei/api/v1/dataset/42694bb8-fc9d-4d82-af7a-0ad6f4c9ad57?scope=resourceAquire')
  .then(function(response) {
    return response.json();
  })
  .then(function(myJson) {
    let gateIdx = 1;
    let gateways = [];

    for (let index = 0; index < myJson.result.results.length; index++) {
      let element = myJson.result.results[index];
      let lat = element["經度"];
      let lng = element["緯度"];
      let name = element["出入口名稱"];
      let num = parseInt(element["出入口編號"]);
      let gateway = {
        "經度": lat,
        "緯度": lng,
        "出入口名稱": name,
        "出入口編號":num,
      }
      

      // console.log(gateIdx);
      if (num >= gateIdx) { //有其他出入口，存入後繼續存
        gateways.push(gateway);
        gateIdx++;
      } else if (num < gateIdx) { //編號開始小於idx，即新的車站開始，先執行之前資料，再開新空間存並設定idx
        addGatewayPosMarker(gateways);
        // console.log(gateway);
        
        if (num === 0) {
          gateways = [];
          gateways.push(gateway);
          addGatewayPosMarker(gateways);
          gateways = [];
        } else if (num === 1) {
          gateways = [];
          gateways.push(gateway);
          gateIdx = 1;
          gateIdx++;
        }
      }else if (num === 0) { //只有此出入口，直接存入執行
        gateways = [];
        gateways.push(gateway);
        addGatewayPosMarker(gateways);
        gateways = [];
      }      
    }
    //非同步
    // console.log(parkinglots[1]);
  })
}

function addGatewayPosMarker(arr) {
  // console.log(arr);
  let lngLatSet = [];
  arr.forEach(element => {
    let temp = [];
    temp.push(element["緯度"]);
    temp.push(element["經度"]);
    lngLatSet.push(temp);
  });

  L.polygon(lngLatSet,
    {
      color: "red",
      title: arr["出入口名稱"],
    }).addTo(mymap);
}