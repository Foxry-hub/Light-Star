<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - Light Star Media</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-1: #030c28;
            --bg-2: #07153d;
            --card: rgba(8, 22, 61, 0.72);
            --line: rgba(56, 189, 248, 0.2);
            --text: #f8fafc;
            --muted: #94a3b8;
            --accent: #22d3ee;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: Inter, sans-serif;
            color: var(--text);
            background:
                radial-gradient(900px 400px at 20% 15%, rgba(34, 211, 238, 0.14), transparent 60%),
                radial-gradient(700px 340px at 80% 85%, rgba(56, 189, 248, 0.12), transparent 62%),
                linear-gradient(140deg, var(--bg-1), var(--bg-2));
            padding: 1rem;
        }

        .card {
            width: min(760px, 100%);
            border: 1px solid var(--line);
            background: var(--card);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 2.25rem;
            box-shadow: 0 20px 60px rgba(2, 10, 31, 0.5);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .logo img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        h1 {
            margin: 0;
            font-size: clamp(1.6rem, 3.2vw, 2.5rem);
            line-height: 1.15;
        }

        p {
            margin: 0.85rem 0 0;
            color: var(--muted);
            font-size: 1.02rem;
            line-height: 1.75;
        }

        .badge {
            margin-top: 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            border: 1px solid var(--line);
            color: var(--accent);
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.46rem 0.9rem;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--accent);
            box-shadow: 0 0 12px var(--accent);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.45;
                transform: scale(0.7);
            }
        }

        @media (max-width: 640px) {
            .card {
                padding: 1.45rem;
                border-radius: 18px;
            }

            p {
                font-size: 0.95rem;
                line-height: 1.65;
            }
        }
    </style>
</head>

<body>
    <main class="card">
        <div class="logo">
            <img src="{{ asset('assets/images/light-star-media-logo.png') }}" alt="Light Star Media Logo">
            <strong>light star media</strong>
        </div>

        <h1>Website sedang maintenance</h1>
        <p>
            Kami sedang melakukan pembaruan sistem untuk meningkatkan layanan. Mohon coba kembali beberapa saat lagi.
            Terima kasih atas pengertiannya.
        </p>

        <div class="badge">
            <span class="dot"></span>
            Maintenance Mode Active
        </div>
    </main>
</body>

</html>
