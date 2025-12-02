import './bootstrap';
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let bookmarks = [];

// Load bookmarks from DB
async function loadBookmarks() {
    const res = await fetch('/bookmarks', { headers: { 'X-CSRF-TOKEN': CSRF } });
    bookmarks = await res.json();
    renderBookmarks();
}

// Render bookmarks on the right column
function renderBookmarks() {
    const list = document.getElementById('list');
    list.innerHTML = '<h2>Bookmarked Songs</h2>';
    if(bookmarks.length === 0){
        const div = document.createElement('div');
        div.textContent = 'No bookmarks yet.';
        list.appendChild(div);
        return;
    }

    bookmarks.forEach(b => {
        const item = document.createElement('div');
        item.style.display='flex';
        item.style.alignItems='center';
        item.style.justifyContent='space-between';
        item.style.borderBottom='1px solid #eee';
        item.style.padding='8px 0';

        const left = document.createElement('div');
        const title = document.createElement('a');
        title.href = b.url;
        title.target = '_blank';
        title.textContent = b.title || b.url;
        left.appendChild(title);

        const artist = document.createElement('div');
        artist.textContent = (b.tags && b.tags[0]) ? b.tags[0] : '';
        left.appendChild(artist);

        const delBtn = document.createElement('button');
        delBtn.textContent = 'Delete';
        delBtn.onclick = async () => {
            await fetch(`/bookmarks/${b.id}`, { method:'DELETE', headers: {'X-CSRF-TOKEN': CSRF} });
            bookmarks = bookmarks.filter(x => x.id !== b.id);
            renderBookmarks();
        };

        item.appendChild(left);
        item.appendChild(delBtn);

        list.appendChild(item);
    });
}

// Add bookmark form submission
document.getElementById('addForm').addEventListener('submit', async e => {
    e.preventDefault();
    const form = e.target;
    const fd = new FormData(form);
    const res = await fetch('/bookmarks', { method: 'POST', body: fd, headers: {'X-CSRF-TOKEN': CSRF} });
    const data = await res.json();
    bookmarks.unshift(data); // add new bookmark on top
    renderBookmarks();
    form.reset();
});

loadBookmarks();
