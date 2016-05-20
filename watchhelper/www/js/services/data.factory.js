angular.module('watchHelper').factory('filmFactory', ['$http', '$q', function ($http, $q) {
    var addFilmUrl = 'http://laparser.loc/addfilm';

    return {
        getToken : function (_url) {
            var deferred = $q.defer();

            $http.get(_url).then(function (response) {
                deferred.resolve(response.data.token);
            });

            return deferred.promise;
        },

        getFilmData : function (_url) {
            var deferred = $q.defer();

            $http.get(_url).then(
                function (response) {
                    deferred.resolve(response.data);
                },
                function (error) {
                    console.error('ERROR! ', error);
                }
            );

            return deferred.promise;
        },
        
        addFilm : function (_url, _token) {
            var deferred = $q.defer();
            console.log('_url', _url);
            $http.post(addFilmUrl, {filmUrl : _url} , {'headers' : {'X-CSRF-Token' : _token}}).then(
                function (response) {
                    console.log('response', response);
                    deferred.resolve(response);
                },
                function (error) {
                    console.error('ERROR! ', error);
                }
            );

            return deferred.promise;
        }
    }
}]);