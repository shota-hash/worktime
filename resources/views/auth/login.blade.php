<x-guest-layout>
    <div class="all">
        <header class="header">
            <div class="head_content">
                <p class="head_wrapper">Atte</p>
            </div>
        </header>
        <div class="content">
            <div class="content_wrapper">
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <p class="content_logo">ログイン</p>
                    <!-- Email Address -->
                    <div>
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />

                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>
                    <button class="ml-3">ログイン
                    </button>
                    <p class="content_turn">アカウントをお持ちで無い方はこちらから</p>
                    <a href="./register" class="content_logo">新規登録</a>
                </form>
            </div>
        </div>
        <footer class="footer">
            <samll class="footer_logo">Atte,inc</samll>
        </footer>
    </div>
</x-guest-layout>
<style>
    *,
    *:before,
    *:after {
        box-sizing: border-box;
    }

    .all {
        width: 100%;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 70px;
        padding: 0 20px;
        color: black;
        background-color: white;
    }

    .header_content {
        width: 8%;
        margin-right: auto;
    }
    .content_logo {
        text-align: center;
        width: 100%;
        display: block;
    }
    .content {
        background-color: rgb(192, 192, 192);
        width: 100%;
    }

    .content_wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 10%;
        padding-bottom: 10%;
    }

    .ml-3 {
        margin: 10% auto;
        width: 100%;
        display: block;
        text-align: center;
        background-color: #000;
        color: #fff;
        padding: 10px;
        cursor: pointer;
    }

    .footer {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .footer_logo {
        margin: 10% auto;
    }
</style>