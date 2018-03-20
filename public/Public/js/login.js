/**
 * Created by Administrator on 2018/2/3 0003.
 */
$(function () {
    var encrypt = new JSEncrypt();
    var publickey = '-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBiYEk6LHMqqUm6WJCcSNfjlPZXPj/zHjmuVuU/QLE/yKqv2YEiPiGxaajZdBL4WUNRQxO4Dt4MDrjN43CsAzQj6OT/fDgroPERccBnwAZQr5FTR4GFfhxcoWxT/2nfmIVI7nHoJSeV7nHHwBBwagb4Z5EDrQDKr3vsumk9DY98wIDAQAB-----END PUBLIC KEY-----';
    encrypt.setPublicKey(publickey);
    $('.btn-login').click(function () {
        var account=$('#LoginName').val();
        var password=$('#LoginPassword').val();
        account = encrypt.encrypt(account);
        password = encrypt.encrypt(password);
        $.ajax({
            url:'/manager/index/logins',
            type:'post',
            dataType:'json',
            data:{'phone':account,'password':password},
            success:function (data) {
                if(data.res=='success'){
                    location.href='/manager/index/index';
                }else if(data.res=='error'){
                    alert('账号、密码错误');
                    location.reload();
                }else if(data.res==null){
                    alert('账号未注册,为您跳到注册界面');
                    location.href='/manager/index/register';
                }

            }
        })
    })
})