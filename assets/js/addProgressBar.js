(function ( $ ) {

    $( document ).ready( function () {

      //Set HTML for displaying the progress bar
      const customHTML = `<div id="progressBar" style="border-bottom-color: ${ progressBarDetails.greyedOut };">
        <span id="progressBorder"></span>
        <span id="progressSearch" class="progressPosition active">
          <span class="circle"></span>
          ${ progressBarDetails.step1 }
        </span>
        <span id="progressDetails" class="progressPosition">
          <span class="circle"></span>
          ${ progressBarDetails.step2 }
        </span>
        <span id="progressConfirmed" class="progressPosition">
          <span class="circle"></span>
          ${ progressBarDetails.step3 }
        </span>
        </div>`;
      
      //Set inline CSS for inactive and active steps
      const inactiveCSS = { borderColor : progressBarDetails.greyedOut };
      const activeCSS = { borderColor : progressBarDetails.activeColor, backgroundColor : progressBarDetails.activeColor };

      //Display progress bar before search results, if class exists on page
      if ( $( '.mphb_sc_search_results-wrapper' ).length > 0 ) {
        
        $( '.mphb_sc_search_results-wrapper' ).before( customHTML );
        $( '#progressBorder' ).css( 'border-bottom-color', progressBarDetails.activeColor );
        $( '#progressSearch .circle' ).css( activeCSS );
        $( '#progressDetails .circle' ).css( inactiveCSS );
        $( '#progressConfirmed .circle' ).css( inactiveCSS );

      //Display progress bar before reservation submitted, if option is enabled and class exists on page
      }else if ( progressBarDetails.showSubmitted === 'on' && $( '.mphb-reservation-submitted-title' ).length > 0  ){
        
        $( '.mphb-reservation-submitted-title' ).before( customHTML );
        $( '#progressSearch .circle' ).css( activeCSS );
        $( '#progressDetails .circle' ).css( activeCSS );
        $( '#progressConfirmed .circle' ).css( activeCSS );
        $( '#progressBorder' ).css( { width : '100%', borderBottomColor : progressBarDetails.activeColor } );

      //Display progress bar before checkout, if class exists on page
      }else if ( $( '.mphb_sc_checkout-wrapper ' ).length > 0 ) {

        $( '.mphb_sc_checkout-wrapper' ).before( customHTML );
        $( '#progressSearch .circle' ).css( activeCSS );
        $( '#progressDetails .circle' ).css( activeCSS );
        $( '#progressConfirmed .circle' ).css( inactiveCSS );
        $( '#progressBorder' ).css({ width : '50%', borderBottomColor : progressBarDetails.activeColor });

      //Display progress bar before booking confirmation, if class exists on page
      }else if ( $( '.mphb_sc_booking_confirmation ' ).length > 0 ){

        $( '.mphb_sc_booking_confirmation' ).before( customHTML );
        $( '#progressSearch .circle' ).css( activeCSS );
        $( '#progressDetails .circle' ).css( activeCSS );
        $( '#progressConfirmed .circle' ).css( activeCSS );
        $( '#progressBorder' ).css( { width : '100%', borderBottomColor : progressBarDetails.activeColor } );

      }
    });
  
  })( jQuery );