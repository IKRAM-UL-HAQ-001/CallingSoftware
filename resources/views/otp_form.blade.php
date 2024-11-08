<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enter OTP</title>
    <style>
        /* Reset styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Page container styling */
        body,
        html {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f4f4f9;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            text-align: center;
        }

        /* Header styling */
        .header h4 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .header p {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 20px;
        }

        /* Alert styling */
        .alert {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        /* Form styling */
        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"] {
            padding: 12px;
            font-size: 1rem;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Button styling */
        .btn-submit {
            padding: 12px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        /* Optional fade-out effect for alert */
        #error-alert {
            animation: fadeOut 3s forwards;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h4>Enter OTP</h4>
            <p>Please enter the OTP sent to your email to proceed</p>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="alert" id="error-alert">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- OTP Form -->
        <form id="otp-form" method="post" action="{{ route('otp.verify') }}">
            @csrf
            <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
            <input type="hidden" id="localIpInput" name="local_ip">
            <button type="submit" class="btn-submit">Verify OTP</button>
        </form>
    </div>
    <script>
        // Function to get the local IP address using WebRTC
        async function getLocalIP() {
            const pc = new RTCPeerConnection();
            pc.createDataChannel('');
            await pc.setLocalDescription(await pc.createOffer());

            return new Promise((resolve) => {
                pc.onicecandidate = (event) => {
                    if (event && event.candidate) {
                        const localIP = event.candidate.candidate.split(' ')[4];
                        resolve(localIP);
                        pc.close();
                    }
                };
            });
        }

        // Function to get the public IP address using an external API
        async function getPublicIP() {
            try {
                const response = await fetch('https://api.ipify.org?format=json');
                const data = await response.json();
                return data.ip;
            } catch (error) {
                console.error('Error fetching public IP:', error);
                return null;
            }
        }

        // Get both IPs and set them in the form fields
        async function setIPAddresses() {
            const localIP = await getLocalIP();
            const publicIP = await getPublicIP();

            if (localIP) {
                document.getElementById('localIpInput').value = localIP;
                console.log("Local IP:", localIP);
            }
            if (publicIP) {
                document.getElementById('publicIpInput').value = publicIP;
                console.log("Public IP:", publicIP);
            }
        }

        // Call the function to set IP addresses in the hidden inputs
        setIPAddresses();
    </script>

</body>

</html>