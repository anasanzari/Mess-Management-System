/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var appDirectives = angular.module('AppDirectives', []);
       
/*
appDirectives.directive('bullzImage', function() {
return {
template:'<div class="bullz-image"><img src="j"/><div class="prog"><md-progress-circular class="md-hue-2" md-mode="indeterminate"></md-progress-circular></div></div>',   
replace:true,
link:function(scope,element,attrs){
    var div = angular.element(element);
    var image = div.children("img");
    var progress = div.children(".prog");
    var img = null;
    var loadImage = function(){
        image.hide();
        progress.show();
        img = new Image();
        img.src = attrs.mySrc;
        img.onload = function(){
            image.attr('src',attrs.mySrc);
            image.show();
            progress.hide();
        }
    }
    scope.$watch((function(){
        return attrs.mySrc;
    }), function(newVal, oldVal){
        
       if(oldVal!=newVal){
           loadImage();
       } 
    });
}
};
});
*/






