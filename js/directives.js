
var appDirectives = angular.module('AppDirectives', []);

appDirectives.directive('messRating', function() {
return {
template:'<span ng-repeat="r in ratings" ng-class="r<=rate?'+"'rated':'notrated'"+'" ng-click="change(r)"></span>',
replace:false,
transclude: true,
scope:{
  r: '&onRate' 

},
link:function(scope,element,attrs){
    var div = angular.element(element);
    scope.ratings = [1,2,3,4,5];
    scope.rate = attrs.rating;
    scope.change = function(rate){
        scope.rate = rate;
        scope.r({rating:rate});
    }
    
}
};
});




