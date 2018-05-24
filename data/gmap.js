// =============
// ▼ 座標取得
// =============
function getPos(){
    return new Promise(function(resolve, reject){
        if (! navigator.geolocation) {
            // GPSに対応していない
            $('#gmap').before('<p>お使いの端末では座標を取得できません。</p>');
            var GPSlat = 35.680786;
            var GPSlng = 139.766405;
            var GPSlatlng = GPSlat+', '+GPSlng;
            resolve(GPSlatlng);
        }else{
            // GPSに対応している
            navigator.geolocation.getCurrentPosition(function(pos) {    // 座標取得
                // 取得成功時の処理
                // var GPSacc = pos.coords.accuracy;

                var GPSlatlng = pos.coords.latitude+', '+pos.coords.longitude;
                resolve(GPSlatlng);
            });
        }
    });
}
// =============
// ▲ 座標取得
// =============

getPos().then(function(result){console.log(result)});
