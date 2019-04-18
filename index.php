<?php
require_once("dompdf/dompdf_config.inc.php");
require_once("db_connect.php");

$query = "SELECT * FROM list";
//echo $query;
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;
//var_dump($data);

$html =
'<html><meta http-equiv="content-type" content="text/html; charset=utf-8" /><body>'.
/*'<img src='.  $data['0']['foto'] . '>'.*/
'<img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD//gA7Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2OTApLCBxdWFsaXR5ID0gNzUK/9sAQwAIBgYHBgUIBwcHCQkICgwUDQwLCwwZEhMPFB0aHx4dGhwcICQuJyAiLCMcHCg3KSwwMTQ0NB8nOT04MjwuMzQy/9sAQwEJCQkMCwwYDQ0YMiEcITIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIy/8AAEQgAcADIAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A9ii0mdY9jXEe5ECnaeh9elJ/Z02+Nftilm5A7Ef98+xrc2/7R/Sk8sbg38Q4BwMiq5mSopHOyWZdJEa/WNt2NwOCvfHI9qpX2pWtncRR/at5kZVGx1wWbOByO+DXWG1iOcopycngcmsC70+0n12RZoIpFSOORdyj5WBbBHofeqU29GDRUXUBJhFw55G0TRkn8M1GlxcRb93msGcsMunyj0HtW99j084OH46HPSmtZ6bnDb8+7VSkrWZDT6GJ/aTgnKOc9PnTimm7m4xBJ7/MvPFbn9m6Yf4H/OorqztY4i0CKWwcedIVXPbJFPmh5i5Z+Rii4uAfuykemUqX7ZLg/wCjyc9PmXirXkToMy2diDv2kC8k4z0/g60RwTyxuyWNkzIxUqt4+CR1GdnBo56fmHLPyMye9lghaRkmwOT8yVWtdcN1bxyRRs6Ocg+Yo3dsdK31sZ5CqzadZhSfmxeOfyGz+tM+wXETFI9Ns/LGdp+2OvfjjYcUc8PMOSfkc9HeXEF3cSO0pjk2hIt64iwMHH1q1HrDxsW8tiPQyJXQRWAaPM1rCkmfupcOwx9SB79qcdPi7W8eP+uzf4UOcPMOWfkYA1tlK/uDuyMkyLk0h1qTOSj49PMT/CuiTTrck74FUdsSsaf/AGbZ/wDPP/x8/wCNLnp+Ycs/I5qTWXkDAQkErgHzF+U88j3/AMKit7+6s7WKG4aaRwDmRpEBbJJHr9Pwrqv7Ns/+ef8A4+f8aP7Ns/8Ann/4+f8AGnzw8w5Z+RzY1mbYWETFdwyfNX8q0k8SgphbaVRtC4WVeD61pf2bZ4x5f/j5/wAaP7Os/wDnn/4+f8aTlTfcaVRdiKLX5jECNPlfHBYypk1i6z4gVZIklt3SUhtpeRMkE57enSuiFlbDop/77P8AjSNY2rH5owfqx/xqG4/ZLSbfv7HEaPMby8kLNbpGwO0b8gZJA59ulas+mTCzkzqNuu1SxIZuMfhVlIYl8YiFVwggTj/gRrqGsoHUo0alWGCCBgirlU5laW/kZ+yV3y7HI6JoOoNGtxPf29wkq/IUZuR+Iorqblk0+zBjUIiYVVVRgAnsKKzUnFWRSppIu0UUVJoFYVxj+3rjdjb9nTOfq1btYc/Gu3DekCdPq1NbiZjGG1n1CeOOHR5Zy5yrH5++cjB59fWtQ6Vp5ABsbcj08oVUa4ljvT/pM/l+Ycp9hY9+gYDp71eivoppRGqThv8AagdR+ZGO1UIdb2draZNvbxRZGD5aBc/lU3kNcMEWQoc5zilqW0YG5xg8e1Jgim+iXskiE6oxRWB2GIHoc9SeOOKsLpUqZ2XRXJycLjJ9etadFSUZUtkyIyzTPKrqeFJU8c8EHP5VDGIY4tgN6cnO4rPu/PGccdqv6jJHFGrSSrGOfmYcCsuW48uRW+3KY5AWTEQIx9aAD/hIIrb9xsm/d/KMqzZx74OfrSnxGgGfLlwRkYjJ/pUAvosbjfqcEZ/cjFEWp28bbpr1JVHGFhA7evNAFqHxAs06RCOUFiACYyB+eK0vPb++KprdW7xiRVyh6EAc1OFQjO0flQBL57f3xR57f3xUexP7q/lRsT+6PyoAk+0N/fFHnt/fFR7E/ur+VGxP7q/lQBJ57f3xR57f3xUexf7q/lRsX+6PyoAwEOfHJ5ziBP5muurk1QL42BAxmBP5muspsSM/Wf8AkHN/vr/MUUaz/wAg5v8AfX+YopDNCikpaACsK4JHiCfAJ/0dOB35NblcZ4nn1e31Vm0a3SecxoHVwOF+bnqO+KunHmlYipLljzFiVbj7RLth1LaWJBSaPaee2TkfQ1PBcTxII/sV4+BnfI0ZP0OGrkWufFkvzXenQo4zt2gdP+/g96fFd+L4INtrYRuN3O5Qf1MhPpXR9Wl/MvvOb61H+V/cdaL+c/8AMLvB+Mf/AMXWjYktKrsroWGSjEZXjpxxXBf2l47/AOgXb/kP/iq3PC154iuNVKavaRwwiJjlQOHyMDhj2z2pTw7jFvmX3lQxMZSUeV/cdnRSUVynUVL+WKFEeY4XP90nms6S8t5JAVnIxwR5JP8AT3rWuOq/jVAQ3ImLG6BjOcJ5YH059qAKoubfBP2nPOf9R/8AWqSErNlUnyQM8wY/mKkaC6LArcAADoec0ggvOf8ASF/75P8AjTsK48wNk4kHP/TMcU7ZNgATn/vgVEYLvI/0hcDqMHmlMN3twJ0z64P+NFguSFJe07D/AIAKNk3H788dfkHNMSG6BG6ZWHcYIqzx/wA8v/IposFyEpNjicjjrsFBSXj9+w/4AOamyP8Anl/5FNGR/wA8v/IposFxiB1J3SFgeny4xT8/X8qOP+eX/kU1HKjuB5YEZ9d5NFguYiknxx/2wT+ddbXIxgjxtgnJECc/jXW0MEUNZ/5Bzf76/wAxRRrP/IOb/fX+YopDNCio5kkkgdIpDFIVIV9oO0+uD1rL/s3WP+g+/wD4Cx0m2uhpCEZLWSX3/ojYrBuCB4hnJ6C3T+Zqb+zdY/6D7/8AgLHWe+i6q+oSTf26Q5QISbZBwP8A9dCk+xTow/nX4/5Dby+tRKUe8tFZcgrNFuxg/UVLFf6fBFhZY0GeSkZVScAn+f8AnFINE1cNn/hICRzwYE/wp39j6v8A9B4f9+E/wp8z7C9jD+dfj/kSxajaTyrFFOrO3QAGr9qB9oB7kVl/2Pq//QeH/fhP8KqONRtJ0VtXu2Zuhi04OvJI5IBA6d6OZ9g9jD+dfj/kdfSVyZvNQABOr6hycY/sknH/AI5SNe36SMjaxfgg4ONKJHX1Cd6nmfYr2UP51+P+R0d7521PJ2bsnO/OMfhVES3JJ/eWvGQQGPB//XWVJLqDQecdYvdittP/ABLMEcZzt25x74qolu0knF/cb3YFi2jY+b1JKfqaOZ9g9lD+dfj/AJHQrNKrgzS2ypjnDHP61Y3rkDeuT0HrWD/ZF0M/8TLtg/8AEvj5H5UraddttLarIdnC509ePpxRzPsHsofzr8f8jd3qf416Z/Cn7H9D/wB8msJdFvSQ41UBjzn7FGD/ACqx9h1j/oPy/wDgMlHM+weyh/Ovx/yNXY/of++aNj+h/wC+ayvsOsf9B+X/AMBko+w6x/0H5f8AwGSjmfYPZQ/nX4/5Grsf0P8A3zRsf0P/AHzWV9h1j/oPy/8AgMlH2HWP+g/L/wCAyUcz7B7KH86/H/I1GDKMnIHuKh+0xbtvmru9Mc1QbT9XYYbXpCPe2Sqr6FeCQTHVcy5A3m0jz+dHM+weyh/Ovx/yEQg+N8g5BgT+dddXAJY6gPF/ljVmEghT959nTpnpiunGm6vkZ15yP+vWOm5PsJUofzr8f8ixrP8AyDm/31/mKKl1GA3FmYw20lgc/Q0UzEt0UUUAFYmreYFkaOSdG3DmFAzD8CK26w9XiMiyBY2kYkDasxjJ+hH400JlK1E87n/TL9duCRLAiA/+OVMLG4AGNTuug/hj5/8AHafYF1g2SQyQ4JwJZvMY/jk1azVCEUFUALFiBgsep/KopEvgC0Ft5gY4/wBZt4yeevFTZA61oWv/AB7r+P8AOpkNbmDHbanOXaa0aEl1fCzA5I5xx2q9/p//AD7L+f8A9etaqOqX32C3SQ5CvII2lCFhEDn5iB26D8alu2pcIOUuWO7KEk1wkqgXEEfTfG8RYj1wQwqeKcPcH97G8XXYEbd+ecfpXM3ptLiZmfWElbPBeNCP5Co4JYoQyi90wq4w2bXORnvl8dvSp50b/VZ/0pf5HaPJFGhd42VR1JJ4qH7bZjuP++jXKGWzK7DqdtHldp2xxLwevUZpbS2tf7Qt0jaC/glyrmOMb4TgkMSOCp6fiKOdB9VnZv8ARr81Y66Oa3lBKLuA64Y0/Mf/ADzP/fRqpb2UNohS3Xy1JzhelTbD/farOYlzH/zzP/fRozH/AM8z/wB9Goth/vtRsP8Afb9KAJcx/wDPM/8AfRozH/zzP/fRqLYf77UbD/fagCXMf/PM/wDfRqOYqUG1cfMvfPek2H++1MkQ7R87H5l/mKAMVf8AkeD/ANcE/nXW1yS/8jwf+uCfzrrabEiKf/VfjRRP/q6KQyWiiigArB1sxCOXzPsvVf8Aj5+5171vVwWueO7DTNYubGW1uXeJwrFQpB4B7mtaVKdR2grmVWrCmrzdiaM6cdmV0XyG+Y4Ycj1HGD0NacV9pVtCFiurSKLkgK6hff8AnXKf8JqisuVZlzz8sXP/AI/Uj/EXS1Yq1hcEg9thH862WErP7Ji8XQX2jqxfWdyTDDdW0sjA4QSBs/gDW1a/8ey/j/OvO4/iNpZdVWxuVJ4GdgA/Wu60S+TUtGtryNWVJlLBW6jk1nVoVKavNWNKVenUdoO5oUlLRWBuYN3A7TyusczkvxtndB09jinQvNCgjS2l2Du7lj+ZJNF1ak3MkqRzsxbotyyL9cA/hUYtvnX/AEe7wDnm7Y8/99c07isT/abnbkWrZxwOP8aUXE/e3cfgP8ag8hsBvs10SBwpu2x+PzUG1Drta3uwD3F02fz3ZouFiYXNyetqw/L/ABq0jbkBZyrHqvlk4rO+zb1w9tdAf9fbZ/8AQvc1aGn2ssS+YZQccgyOT+eeaLhYsfL/AM9f/IRo+X/nr/5CNVxploP+W1z9fPlz+e72pTploRjzrjH/AF2k/wDiqLhYn+X/AJ6/+QjR8v8Az1/8hGof7OtQMedcY/67Sf8AxVINNtR/y2uPr58uf/QqLhYn+X/nr/5CNV5JJPN27cx7h8+3HpVmOGKJAiytgf3ssfzNQTO4mCBcx7h82PpRcLGMv/I8H/rgn866yuTX/keD/wBcE/nXW0MERT/6uiif/V0UhklLXjQ+Iev/ANlmU3K+eJQgHlJzxnPTpWraeOtUuUUfaI4ykO5y0ane2Og7DnH51UouKuyI1ISdkz1Csq6ijNw5MSMSeTtFcJd+Otdt9OtZ4LaWdpC4fZCr4O7C8AjAx35rpHv4ryxV55Lfz2ALJJP5Z/MdODVcko6lOzSY+K0EkihormIAZJbyyPp3NX/s8P8Azyj/AO+RWTBFpXlKZpoVkIwyi9Z1/U/0qUpopOftMI+lyR/7NRqRoaDW0LKR5aDPcKM1qWihbVAAABngfWsOC6022j8uK7t1XOcGYH+ZrTttTsBAoN9bZ5481fX60pXGrGhSVVGqaef+X+1/7/L/AI0f2pp4631r/wB/l/xqbMq6M64tFe5mbZdN5hwTHcMgH0AYY6dqYICwwba6A9rts/8AoVU76aze5aaKXT3YuSWknUfQ+9V1mj2GMnSxHksALofePfpQl3Hc6CG0gUrKXlV/7rSOwB+mcVY2x/8APT/x01zMc8LyZmOmgc8rcqxHHuBWh5mi4x59njGP9av+NVaPn9wrmttj/wCen/jpo2x/89P/AB2slZNEXG2ezGOn71f8as/2pp//AD/23/f1f8aTXYLl3bH/AM9P/HTRtj/56f8Ajpql/amn/wDP/a/9/l/xpP7V07/n/tf+/wAv+NKzC6L22P8A56f+OmjbH/z0/wDHTVH+1dO/5/7X/v8AL/jSHVtNHXULQfWZf8aLMLov7Y/+en/jpqOdV8rCyHJYchenNU/7a0r/AKCdn/3/AF/xqnquuaemk3Tw6naiVYmZCkyE5A4wKEmF0U7Kf7T4tim4zJaxsQO2a7KvC4PEbaWjPpt5GJUKKpaPcWX8R2q/B4+8STSkfbotg6nyo1P61o6bZHOloz2Gf/V0V4/deOPEfyKtzFKrgEKYoyc4zyB05opeykP2iP/Z
">'.
'<p>herny !</p>'.
'</body></html>';

echo $html;




$dompdf = new DOMPDF(); // Создаем обьект
$dompdf->load_html($html); // Загружаем в него наш HTML-код
$dompdf->render(); // Конвертируем HTML в PDF
$dompdf->stream("new_file.pdf"); // Выводим результат на скачивание

