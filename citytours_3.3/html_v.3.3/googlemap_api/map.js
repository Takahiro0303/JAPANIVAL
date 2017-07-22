var lat = $('#keido').text();
var lng = $('#ido').text();
console.log(lat);
console.log(lng);


// 地図のインスタンスを作成する
var map = new google.maps.Map( document.getElementById( 'map-canvas' ), {
	zoom: 15 ,	// ズーム値
	center: new google.maps.LatLng(lat , lng) ,	// 中心の位置座標
} ) ;

// マーカーのインスタンスを作成する
var marker = new google.maps.Marker( {
	map: map ,	// 地図
	position: new google.maps.LatLng(lat , lng) ,	// 位置座標
} ) ;

