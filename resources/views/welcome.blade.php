<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SubscLog</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800">

<div class="min-h-screen flex flex-col">
    <!-- 背景ぼかし -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-primary-100 rounded-full blur-3xl opacity-40"></div>
    <div class="absolute bottom-20 right-10 w-80 h-80 bg-blue-100 rounded-full blur-3xl opacity-40"></div>

    <!-- Navbar -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl">
                <x-application-logo />
            </h1>
            <div class="space-x-3">
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-500">ログイン</a>
                <a href="{{ route('register') }}"
                   class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                    新規登録
                </a>
            </div>
        </div>
    </header>
    <!-- Main -->
    <main class="flex-1 flex items-center z-10">
        <div class="max-w-7xl mx-auto px-6 w-full">
            <div class="grid md:grid-cols-2 gap-12 items-center">

                <!-- Left -->
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                        サブスクを、<br>
                        <span class="text-primary-500">もっとシンプルに管理</span>
                    </h2>

                    <p class="text-lg text-gray-600 mb-6">
                        更新日や月額料金を見える化して、
                        無駄な支出を防ぎます。
                    </p>

                    <a href="{{ route('register') }}"
                       class="inline-block bg-primary-500 text-white px-6 py-3 rounded-xl text-lg font-semibold hover:bg-primary-700 shadow">
                        無料で始める
                    </a>

                    <!-- Features -->
                    <div class="grid grid-cols-3 gap-4 mt-10 text-center">
                        <div class="bg-white p-4 rounded-xl shadow-sm">
                            <div class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-2">
                                <x-icons.calendar class="w-4 h-4 fill-current" />
                            </div>
                            <p class="text-sm font-medium">更新日管理</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm">
                            <div class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-2">
                                <x-icons.money class="w-4 h-4 fill-current" />
                            </div>
                            <p class="text-sm font-medium">料金一覧</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm">
                            <div class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-2">
                                <x-icons.chart class="w-4 h-4 fill-current" />
                            </div>
                            <p class="text-sm font-medium">支出確認</p>
                        </div>
                    </div>
                </div>

                <!-- Right -->
                <div class="bg-white rounded-2xl backdrop-blur ring shadow-2xl overflow-hidden max-w-lg w-full transform rotate-1">

                    <!-- ブラウザバー -->
                    <div class="bg-gray-100 px-4 py-3 flex items-center gap-2">
                        <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                        <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                        <div class="w-3 h-3 bg-primary-400 rounded-full"></div>
                    </div>

                    <!-- スクショ -->
                    <img src="{{ asset('images/dashboard-preview.png') }}"
                         alt="ダッシュボードプレビュー"
                         class="w-full">
                </div>

            </div>
        </div>
    </main>

</div>
</body>
