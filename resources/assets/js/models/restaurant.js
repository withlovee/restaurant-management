var Restaurant = function () {
  // TODO: return only closest restaurants to the current location
  this.getAll = () => {
    
      let options = {
        url: 'get-restaurants'
      };

      return new Promise(function (resolve, reject) {
        $.ajax(options).done(resolve).fail(reject);
      });
  }
}


module.exports = Restaurant;