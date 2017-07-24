var geocoder = new google.maps.Geocoder();

  geocoder.geocode(
      { address: '' },
      function( results, status )
      {
          if( status == google.maps.GeocoderStatus.OK )
          {
              alert( results[ 0 ].geometry.location );
              console.log(results[ 0 ].geometry.location );
          }
          else
          {
              alert( 'Faild：' + status );
          }
      } );