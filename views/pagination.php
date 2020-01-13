<p class="pages">page <?=$data['currentPage']?> of <?=$data['totalPages']?></p>
    <div align="center">
        <div class="pagination">
            <?php
            $start = 1;
            $current = $data['currentPage'];
            $end = $data['totalPages'];

            $uri = $_SERVER["REQUEST_URI"];

            $index = strripos($uri, 'page');

            if ($index) $uri = substr($uri, 0, $index -1);
            if ($uri == "/") $uri = "/gallery";

            $lastVisible = min($end, $current + (10 - $current%10));
            $firstVisible = max($current - ($current % 10), 1);

            $prev = max($current - 1, 1);
            $next = min($end, $current + 1);

            echo " <a href='$uri/page/1'><<</a> ";
            echo " <a href='$uri/page/$prev'><</a> ";

            for ($i = $firstVisible; $i <= $lastVisible; ++$i) {

                $class = ($i == $current ? "current" : "");
                echo " <a href='$uri/page/$i' class='$class'>$i</a> ";
            }

            echo " <a href='$uri/page/$next'>></a> ";
            echo " <a href='$uri/page/$end'>>></a> ";
        ?>
        </div>
    </div>