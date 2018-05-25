<script>
    var map;
    var infowindow;
    function getLocation(){

        // 位置情報を取得する
        navigator.geolocation.getCurrentPosition(
            function(position) {

                // 現在地の緯度経度所得
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                alert('緯度:' + latitude + ' / 経度:' + longitude);
                var latlng = new google.maps.LatLng( latitude , longitude ) ;
                // 現在地の緯度経度を中心にマップを生成
                map = new google.maps.Map(document.getElementById('map'), {
                center: latlng,
                zoom: 15
                });

                //現在地の緯度経度を中心にマップに円を描く
                var circleOptions = {
                    map: map,
                    center: new google.maps.LatLng( latitude , longitude ),
                    radius: 1000,//1km
                    strokeColor: "#009933",
                    strokeOpacity: 1,
                    strokeWeight: 1,
                    fillColor: "#00ffcc",
                    fillOpacity: 0.35
                };
                circle = new google.maps.Circle(circleOptions);

                //現在地から1キロ以内のレストランを検索
                infowindow = new google.maps.InfoWindow();
                var service = new google.maps.places.PlacesService(map);
                service.nearbySearch({
                  location: latlng,
                  radius: 1000,//1km
                  type: ['restaurant']
                }, callback);
            },function(error) {
                // 失敗時の処理
                alert('エラー：' + error);
        });
    }

    //地図上にマーカーをプロット
    function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
        }
    }
    //地図上のマーカーをクリックした際の動作
    function createMarker(place) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location
        });
        //吹き出しの中身
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + '評価: ' + place.rating  + '</div>');
          infowindow.open(map, this);
        });
    }
    </script>
