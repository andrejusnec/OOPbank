</div>
<div class="col-12 copyRight"></div>
</div>
<script>
    function copyRightRender(selector) {
    const DOM = document.querySelector(selector);
    let year = new Date().getFullYear()
    let HTML = `<p>&copy Copyrights ${year} <a href="https://github.com/andrejusnec">Andrejus Nec & Anonymous PHP fan club</a></p>`;
//output validation
    DOM.innerHTML = HTML;
}
copyRightRender('.copyRight');
</script>

</body>
</html>