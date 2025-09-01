
<style>


    .file-uploader {
        color:#333;
      width: 500px;
      background-color: white;
      border-radius: 5px;
    }
    .file-uploader .uploader-header {
      display: flex;
      padding: 20px;
      background: #eef1fb;
      align-items: center;
      border-radius: 5px 5px 0 0;
      jsutify-content: space-between;
    }
    .uploader-header .uploader-title {
      font-size: 1.2rem;
      font-weight: 700;
      text-transform: uppercase;
    }
    .uploader-header .file-completed-status {
      font-style: 1rem;
      font-weight: 500;
      color: #333;
    }
    .file-uploader .file-list {
      list-style: none;
      width: 100%;
      padding: 20px;
      padding-bottom: 10px;
      max-height: 400px;
      overflow-y: auto;
      scrollbar-color: #999 transparent;
      scrollbar-width: thin;
    }
    .file-uploader .file-item {
      display: flex;
      gap: 14px;
      margin-bottom: 23px;
    }
    .file-list .file-list:has(li) {
      padding: 20px;
    }
    .file-list .file-extension {
      text-transform: uppercase;
      height: 50px;
      width: 50px;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 15px;
      background-color: #51458a;
    }
    .file-list .file-item .file-content-wrapper {
      flex: 1;
    }
    .file-list .file-item .file-content {
      display: flex;
      width: 100%;
      justify-content: space-between;
    }
    .file-list .file-item .file-name {
      font-size: 1rem;
      font-weight: 600;
    }

    .file-list .file-item .file-info .small {
      font-size: 0.9rem;
      font-weight: 500;
      color: #5c5c5c;
      margin-top: 5px;
      display: block;
    }
    .file-list .file-item .cancel-button:hover {
      color: #e3413f;
    }
    .file-list .file-item .cancel-button {
      align-self: center;
      border: none;
      outline: none;
      background: none;
      cursor: pointer;
      font-style: 1.4rem;
    }
    .file-list .file-item .file-info .file-status {
      color: #51458a;
    }
    .close-svg {
      width: 24px;
      height: 24px;
    }
    .file-list .file-item .file-progress-bar .file-progress {
      width: 0%;
      height: inherit;
      border-radius: inherit;
      background: #51458a;
    }
    .file-list .file-item .file-progress-bar {
      width: 100%;
      height: 3px;
      margin-top: 10px;
      border-radius: 30px;
      background: #d9d9d9;
    }
    .file-uploader .file-upload-box.active {
      border: 2px solid #51458a;
      background: #f3f6ff;
    }
    .file-uploader .file-upload-box {
      margin: 10px 20px 20px;
      border-radius: 5px;
      min-height: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px dashed #b1add4;
    }
    .file-upload-box .box-title .file-browse-button:hover {
      text-decoration: underline;
    }
    .file-upload-box .box-title {
      font-size: 16px;
    }
    .file-upload-box .box-title .file-browse-button {
      color: #51458a;
      cursor: pointer;
    }
    .file-uploader .file-uploader-box .box-title {
      font-size: 1.05rem;
      font-weight: 500;
      color: #626261;
    }
  </style>
  <div class="file-uploader">
    <div class="uploader-header">
      <h2 class="uploader-title">File Uploader</h2>
    </div>
    <ul class="file-list"></ul>
    <div class="file-upload-box">
      <h2 class="box-title">
        <span class="file-instruction">Drag File here or</span>
        <span class="file-browse-button">browse</span>
      </h2>
      <input type="file" wire:model="files" class="file-browse-input"  hidden />
    </div>
  </div>
  <script>
    const fileList = document.querySelector('.file-list');
const fileBrowseButton = document.querySelector('.file-browse-button');
const fileBrowseInput = document.querySelector('.file-browse-input');
const fileUploadBox = document.querySelector('.file-upload-box');
const createFileItemHTML = (file, uniqueIdentifier) => {
  const { name, size } = file;
  const extension = name.split('.').pop();
  return `<li class="file-item" id="file-item-${uniqueIdentifier}">
          <div class="file-extension">${extension}</div>
          <div class="file-content-wrapper">
            <div class="file-content">
              <div class="file-details">
                <h5 class="file-name">${name}</h5>
                <div class="file-info">
                  <small class="file-size">4 MB / ${size}}</small>
                </div>
              </div>
              <button class="cancel-button">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="size-6 close-svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18 18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </li>`;
};
const filex = [];
let indexNow = 0;
const handlerSelectedFile = ([...files]) => {
  filex.push(...files);
  if (files.length === 0) return;
  files.forEach((file, index) => {
    const uniqueIdentifier = Date.now() + '_' + indexNow;
    const fileItemHTML = createFileItemHTML(file, uniqueIdentifier);
    fileList.insertAdjacentHTML('afterbegin', fileItemHTML);
    const selected = document.getElementById('file-item-' + uniqueIdentifier);
    indexNow += 1;

    selected.querySelector('svg').addEventListener('click', () => {
      filex.splice(filex.indexOf(file), 1);
      selected.remove();
    });
  });
};

fileUploadBox.addEventListener('drop', (e) => {
  document.querySelector('.file-instruction').innerText = 'Drag File here or';
  e.preventDefault();
  handlerSelectedFile(e.dataTransfer.files);
  fileUploadBox.classList.remove('active');
});
fileUploadBox.addEventListener('dragover', (e) => {
  e.preventDefault();
  console.log('Drag OVer');
  fileUploadBox.classList.add('active');
  document.querySelector('.file-instruction').innerText =
    'Release To Upload or';
});
fileUploadBox.addEventListener('dragleave', (e) => {
  document.querySelector('.file-instruction').innerText = 'Drag File here or';
  e.preventDefault();
  fileUploadBox.classList.remove('active');
});
fileBrowseInput.addEventListener('change', (e) =>
  handlerSelectedFile(e.target.files)
);
fileBrowseButton.addEventListener('click', () => fileBrowseInput.click());

  </script>
