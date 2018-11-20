var a = require('jquery'),
token = a("meta[name='csrf-token']").attr('content');

export{ a, token };