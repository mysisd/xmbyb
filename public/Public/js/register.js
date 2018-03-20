/**
 * Created by Administrator on 2018/2/3 0003.
 */
$(function () {
    var encrypt = new JSEncrypt();
    var publickey = '-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBiYEk6LHMqqUm6WJCcSNfjlPZXPj/zHjmuVuU/QLE/yKqv2YEiPiGxaajZdBL4WUNRQxO4Dt4MDrjN43CsAzQj6OT/fDgroPERccBnwAZQr5FTR4GFfhxcoWxT/2nfmIVI7nHoJSeV7nHHwBBwagb4Z5EDrQDKr3vsumk9DY98wIDAQAB-----END PUBLIC KEY-----';
    encrypt.setPublicKey(publickey);
    $('#register').click(function () {
        var account=$('#RegisterName').val();
        var password=$('#RegisterPassword').val();
        var code=$('#Code').val();
              account = encrypt.encrypt(account);
        	 password = encrypt.encrypt(password);
        $.ajax({
            url:'/manager/index/registers',
            type:'post',
            dataType:'json',
            data:{'phone':account,'password':password,'code':code},
            success:function (data) {
                if(data.ret=='success'){
                   location.href='/manager/index/login';
                }else if(data.ret=='error'){
                    alert('验证码错误');
                    location.reload();
                }else if(data.ret=='repeat'){
                    alert('账号已注册');
                    location.href='/manager/index/login';
                }

            }
        })
    })
})