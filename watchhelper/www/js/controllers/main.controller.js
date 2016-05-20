angular.module('watchHelper').controller('mainCtrl', ['filmFactory', function (filmFactory) {
    var dbUrl = 'http://laparser.loc/getfilms';
    var tokenUrl = 'http://laparser.loc/gettoken';

    this.getToken = function () {
        filmFactory.getToken(tokenUrl).then(function (value) {
            this.token = value;
        }.bind(this));
    };

    this.getFilmData = function () {
        filmFactory.getFilmData(dbUrl).then(function (value) {
            console.log(value);
            this.filmData = value;

            /*temporarily*/
            angular.forEach(this.filmData, function (val,key) {
                if(key % 2){
                    val.status = key;
                }
            });
        }.bind(this));
    };

    this.getToken();
    this.getFilmData();

    this.addFilm = function () {
        filmFactory.addFilm(this.url, this.token).then(function (value) {
            this.getFilmData();
        }.bind(this));
    };

}]);