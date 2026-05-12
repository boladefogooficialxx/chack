<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Identificacao/Continuar');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIE, dirname(__FILE__) . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIESESSION, dirname(__FILE__) . '/cookie.txt');

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'cache-control: max-age=0',
    'content-type: application/x-www-form-urlencoded',
    'origin: https://www8.receita.fazenda.gov.br',
    'priority: u=0, i',
    'referer: https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Identificacao?cnpj=33500680000161',
    'sec-ch-ua: "Not:A-Brand";v="99", "Microsoft Edge";v="145", "Chromium";v="145"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: document',
    'sec-fetch-mode: navigate',
    'sec-fetch-site: same-origin',
    'sec-fetch-user: ?1',
    'upgrade-insecure-requests: 1',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0',
]);
curl_setopt($ch, CURLOPT_COOKIE, 'ARRAffinity=72d5a983ac8e19cdb578924fb14c50fe8e1fe60ef5976ce0065ba4640cc5729c; __RequestVerificationToken_L1NpbXBsZXNOYWNpb25hbC9BcGxpY2Fjb2VzL0FUU1BPL3BnbWVpLmFwcA2=KuyGrSM8bZUxDbYnB5LkEsJMfkeJVpK8PeODxYLvxdG5NGGzvf4YTCrSiFRSza-4czHwX2eaeUJGfzUf24h9xHYMR1wVyPGhCoUx9gyvK5E1');
curl_setopt($ch, CURLOPT_POSTFIELDS, '__RequestVerificationToken=ATj8ZhW6QuIFtbX6vUV-xhUl6iyZeuqa--oxx1yuHmGsqCrtWrVmeCR7K9O8OKaLhmYgbh0bzg2HgDSbCQqX27wDewRv58AO45P96CRoRV41&cnpj=33.500.680%2F0001-61&h-captcha-response=P1_eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.haJwZACjZXhwzmmZC-mncGFzc2tlecUFrSL1V20Ce06b8di86EaBOjgjrV6TBTSvTG0YIeR0_Q1bSiFsQulz3wm94dSdABzhldP89fJqEHmJTVZJec6FsNG_K_rU91deDx3HsPTQSolvcJf_trpzemob14nC4bcBpl_xDM39j_UxYKh6sfA9ypPjGdOwZ0x6fkqXcCUAGVdIP2knPn1l_6k33_Qos5kYH5IbD7TXC8jPynynO4pOznbTVeXViob-oFkKxvTnKokL31KFXbCIOVo5SevBO1yZ1XQWGZea0-Y3_gXJSxvtzMurjqW3BV27gzK8229gSdpbScKsU8K0MezVWyniHOfKfb6-6MfYKczI5zELrIXlwu-AZ6mdXZU2EPX7xj3i1SOn6Cpp2rjqdkuOno7Vo8u6pADh5raSNgsXwFmqYGn7dX2CtEuug-FOjbukNvbgEwtcrdBJ4zVVlRo3pZoq8-AjbWIMUH0h7GkLFwNNl0LhR8DmYim4DqYYFDfs1BHJA-HIX3-2io7YZQH0hH9nU3x9Xu7OFGAsK1VqpQkYCrrMMTDHHStZiRL6f3vaWxOY1xNU2MoYxqRV7gNrllLxSNzeWXCtWT0tD_CNnzh3UEVUIWiF4HbIZvSfG_hShoJxfF1nvxPJyhuokMyp-U3E8mbKmvmm6aDkyF3xE_DA3kxw3EemOrapR4XoQkhEP0UYF-0XcoC3SybJyPC2E1x3k1GkVUUfiSbGOr9Wr_0TfdzHpexujsMC_auvimJlp1G9UV3gPCUe1D7fxe3NbDwzov74l8Ye4ppmvz2XHrcHGLknpbUUjkdDXwbOhTYz9DBPmvx0yeo8tuGV3Afh4otgQ29SyJb-BGY0bM66Ie4yUdfZhjb-MCcsDU75s28J69HvD3c_OF1NtdwwGmRQdEXSo0k3d8fjQcmigpkse_e0lCIewW8M2uiLHjReMPT_jD8uDlRzA6eukZGvkIAieNBMzKSltVtVPNT6KG8RzUqm2OQJqE7GSdDFSP_gDu7jWaWEGYYpGus-9qHbC5AfzHPZjMn4YjoT5l-nYsBoqfyntShlahLDaXFNk5zerrVqRcAX64tvoqPLihQlEa1FDdyO8FxMb_M5tiNIuW8_HnF2A5wZCte06Ph3pGNJe5L9tmvK6RE7GQ22sXgDmqj2JYOrLRKHX8hJZKdEFypY1wZAR7i8lbKghN7OFhhhA1u9Gj4OYctPFUH3MY5P72qmhRY2_PfZOYjJkKxdVXVCVnYqt1hQy3dRo8XEK5w34vjzxbeqYqRhvEfZe_TEFd3BQ71PfAF01Kb_r-G1qd2GsbrLocA-dR8_jVxe4smL8KXdiVMXVxNr-mpFzpTRQGdvOZTqkySCxd1YnK-HJGRmi64rGPL4T9QEWAhJ05UUEqOne90iCJdcYbC2rw0BX83ZS01zCDmJj7gYbbgmyK0tA1kd7CcuPqiva3Jul0OBY-IXeGjhOGmkSXvypsQsYD5Ybd6m6rDVSa7yxbXteJHqeABKObSLLk4QBMtZw0I6b-7pwH-NxCJAgO1ffj_FcMLz5o4RYEXj_gKSQCqvIqmtVS5ECfqeMxdSU7HjeS1xWSZA78dBJOnekn23TLPdwDYJxkT9yxRhvqD86oPbaW7x98gfTHa0FDEFY51ZH1Xxp_dzqFD0AHElpTfQCnWql2bnaVNuZj1vkLiMivTBo-h65NitlWmyOIlaFrXjTypswEgY-9O4RVDgLmrQcNgwpzbiaJwWbNKoDlDwyUZZGvQ3KVjFwMXs9FpHMhDQFb5qxV3Cq2axlQqbMvLFXJIYMqxjvInqaRzMkIxCnyDkQX7f_hqeOuU0f39ME7uXYoYRnf3m3PJNhsXRY8ZAqnowWvwCbUnOdIWCAZ0xs_V0Tz7B4lL4FIVugiIpTv1VqjwAXtQIr4OLVApnm67KlnmF72Gz3LTWTMvsxIFuEoDF-snfa0J8At6ia3KoMzk5ZDg0YjCoc2hhcmRfaWTOBEclkQ.rljaf77enUGYEqNskqn1pcY-izpbQFcUinSks5F-ujg');

echo $response = curl_exec($ch);

curl_close($ch);