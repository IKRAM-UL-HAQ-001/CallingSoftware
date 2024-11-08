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
            <input type="hidden" id="publicIpInput" name="public_ip">
            <button type="submit" class="btn-submit" style="background-color: #acc301">Verify OTP</button>
        </form>
    </div>

</body>
<script>
// Function to get the public IP address using an external API
async function getPublicIP() {
    try {
        const response = await fetch("https://api.ipify.org?format=json");
        const data = await response.json();
        return data.ip;
    } catch (error) {
        console.error("Error fetching public IP:", error);
        return null;
    }
}

// Function to get the local IP address using WebRTC
async function getLocalIP() {
    return new Promise((resolve, reject) => {
        const peerConnection = new RTCPeerConnection({ iceServers: [] });
        peerConnection.createDataChannel(""); // Create a data channel
        peerConnection.onicecandidate = (event) => {
            if (!event || !event.candidate) {
                peerConnection.close(); // Close connection if no more candidates
                return;
            }
            const ipRegex = /([0-9]{1,3}\.){3}[0-9]{1,3}/;
            const ipMatch = ipRegex.exec(event.candidate.candidate);
            if (ipMatch) {
                resolve(ipMatch[0]); // Return the local IP address
                peerConnection.close();
            }
        };
        peerConnection.createOffer()
            .then((offer) => peerConnection.setLocalDescription(offer))
            .catch((err) => reject(err));
    });
}

// Function to get both public and local IPs
async function getIPAddresses() {
    const publicIP = await getPublicIP();
    const localIP = await getLocalIP();

    console.log("Public IP Address:", publicIP);
    console.log("Local IP Address:", localIP);

    return { publicIP, localIP };
}

// Run the function
getIPAddresses().then((ips) => {
    // You can access both IP addresses here
    console.log("IP Addresses:", ips);
});
</script>

</html>