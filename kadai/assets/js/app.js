$(function(){
    $('#menu').on('click', function(){
        $('#hyouzi').toggle();
        $('#hihyouzi').toggle();
    });


    $('#getLocation').on('click',function(){
        getLocation();
    });

    function getLocation(){
        // 位置情報を取得する
        var map;
        var infowindow;
        navigator.geolocation.getCurrentPosition(
            function(position){
                // 現在地の緯度経度所得
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                // alert('緯度は:' + latitude + ' / 経度は:' + longitude);
                var latlng = new google.maps.LatLng( latitude , longitude ) ;
                console.log(latitude);
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
                $('#form1').submit();

            }
        );
    }
});
/*
//↓位置取得のスクリプト
$(function(){
console.log("test");
$('#getLocation').on('click',function(){
console.log("osareta");
function getLocation(){
// 位置情報を取得する
var map;
var infowindow;
navigator.geolocation.getCurrentPosition(
function(position){
// 現在地の緯度経度所得
var latitude = position.coords.latitude;
var longitude = position.coords.longitude;
// alert('緯度は:' + latitude + ' / 経度は:' + longitude);
var latlng = new google.maps.LatLng( latitude , longitude ) ;
console.log(latitude);
$('#latitude').val(latitude);
$('#longitude').val(longitude);
$('#form1').submit();

}
);
}
});
});
*/
