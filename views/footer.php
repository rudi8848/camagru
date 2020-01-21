            </main>
            <footer>
                <div align="center">
                    <?php foreach ($menu as $menuItem):?>
                        <a href="<?=$menuItem['url']?>"><?=$menuItem['text']?></a>
                    <?php endforeach;?>
                </div>
            </footer>

        </body>
    </html>