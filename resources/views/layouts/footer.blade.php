<footer class="footer pt-3   ">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between ">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                    © <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    <a href="#" class="font-weight-bold" target="_blank">HIF Solution</a>
                    for a better web.
                </div>
            </div>
        </div>
    </div>


<!-- Style for search bar -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
<script>

$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#DataTable')) {
        $('#DataTable').DataTable({
            pagingType: "full_numbers",
            order: [[0, 'desc']],
            language: {
                paginate: {
                    first: '«',
                    last: '»',
                    next: '›',
                    previous: '‹'
                }
            },
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10
        });
    }
    });


    const secretKey = CryptoJS.enc.Utf8.parse('MRikam@#@2024!XY'); // 16-byte key for AES
    const iv = CryptoJS.enc.Hex.parse('00000000000000000000000000000000'); // 16-byte fixed IV

    function encryptData(data) {
        return CryptoJS.AES.encrypt(data, secretKey, { iv: iv }).toString();
    }

    function decryptData(encryptedData) {
        const decrypted = CryptoJS.AES.decrypt(encryptedData, secretKey, { iv: iv });
        return decrypted.toString(CryptoJS.enc.Utf8);
    }

    $('.encrypted-data').each(function() {
        const encryptedData = $(this).text().trim();

            const decryptedData = decryptData(encryptedData);
            if (decryptedData) {
                $(this).text(decryptedData);
            } else {
                console.warn("Decryption returned empty text, check the key or data format.");
            }
    });
    
</script>
</footer>