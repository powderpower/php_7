$.fn.checkValidInput = function(rulesOptions = false, falseDefault = false, maxSymbolCount = 255, callback = false)
{
    var b = $(this),
    value = b.val(),
    testResult = true,
    expressions = ['.{1,}'];
    if(rulesOptions) {
        var rules = {
            digits : '^[0-9]{1,' + maxSymbolCount +'}$',
            sitename: '',
            phone: '',
        },
        pushExpr = rulesOptions;

        if(rulesOptions in rules) {
            pushExpr = rules[rulesOptions];
        }

        expressions.push(pushExpr);
    }

    expressions.forEach(function(b)
    {
        if(testResult && !(new RegExp(b).test(value))) {
            testResult = false;
        }
    });

    if(callback) {
        callback(testResult);
    }
    
    if(testResult) {
        return value;
    }
    
    if(falseDefault) {
        b.val(falseDefault);
    }

    return null;
}