<x-guest-layout>
  <div class="all">
    <header class="header">
      <div class="head_content">
        <p class="head_wrapper">Atte</p>
      </div>
      <nav>
        <ul class="header_nav_item">
          <li class="header_nav_list"><a href="/">ホーム</a></li>
          <li class="header_nav_list"><a href="/attendance">日付一覧</a></li>
          <li class="header_nav_list"><a href={{ route('logout') }} onclick=" event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a></li>
          <form id='logout-form' action={{ route('logout')}} method="POST" style="display: none;">
            @csrf
          </form>
        </ul>
      </nav>
    </header>
    <div class="content">
      @foreach ($works as $work)
      {{$work->date}}
      @break
      @endforeach
      <table class="table">
        <tr>
          <th>名前</th>
          <th>勤務開始</th>
          <th>勤務終了</th>
          <th>休憩時間</th>
          <th>勤務時間</th>
        </tr>
        @foreach($works as $work)
        <tr>
          <td>
            @foreach ($users as $user)
            @if ($user->id == $work->user_id)
            {{$user->name}}
            @endif
            @endforeach
          </td>
          <td>
            {{$work->work_start}}
          </td>
          <td>
            {{$work->work_end}}
          </td>
          <td>
            @foreach ($rests as $rest)
            {{gmdate("H:i:s",$rest->rest_time)}}
            @endforeach
          </td>
          <td>
            {{gmdate("H:i:s",(strtotime($work->work_end)-strtotime($work->work_start)))}}
          </td>
        </tr>
        @endforeach
      </table>
      {{$works->links()}}
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

  .header_nav_item {
    display: flex;
    justify-content: flex-end;
  }

  .header_nav_list:not(:last-child) {
    margin-right: 30px;
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
    padding-top: 10%;
    padding-bottom: 10%;
  }

  .ml-3 {
    margin: 10px;
    width: 90%;
    display: block;
    text-align: center;
    background-color: white;
    color: black;
    padding: 50px;
    cursor: pointer;
  }

  .service_list {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
  }

  .service_item:not(:nth-child(2), :nth-child(4)) {
    margin-right: 10px;
  }

  .service_item {
    width: 49%;
    margin: 3% auto;
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