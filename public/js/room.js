// 定义基础数据类型


const POSITION_FLAG_LEFT = 1;
const POSITION_FLAG_RIGHT = 2;
const POSITION_FLAG_TOP = 4;
const POSITION_FLAG_BOTTOM = 8;

const MEDIA_PHOTO = 1
const MEDIA_VIDEO = 2
const MEDIA_STICKER = 3
const MEDIA_GIF = 4
const ALBUM_MESSAGES_LIMIT  = 10

class MessageGroupedLayoutAttempt {
    constructor(lineCounts, heights) {
        this.lineCounts = lineCounts;
        this.heights = heights;
    }
}

class GroupedMessagePosition {
    aspectRatio;
    isEdge;
    flags;
    isLast;
    leftSpanOffset;
    minX;
    maxX;
    minY;
    maxY;
    height;
    width;
    siblingHeights;
    spanSize;

    set(minX, maxX, minY, maxY, w, h, flags) {
        this.minX = minX;
        this.maxX = maxX;
        this.minY = minY;
        this.maxY = maxY;
        this.spanSize = w;
        this.width = w;
        this.height = h;
        this.flags = flags;
    }

    getInfo() {
        return `minX=${this.minX}\nmaxX=${this.maxX}\nminY=${this.minY}\nmaxY=${this.maxY}\nspanSize=${this.spanSize}\nwidth=${this.width}\nheight=${this.height}\nflags=${this.flags}\nsiblingHeights=${this.siblingHeights}\nleftSpanOffset=${this.leftSpanOffset}`;
    }
}

class GroupedMessages {

    constructor() {
        this.posArray = [];
        this.positions = new Map();
        this.maxSizeWidth = 800;
        this.hasSibling = false;
        this.scale = 1.0;
    }

    multiHeight(array, start, end) {
        let sum = 0.0;
        for (let i = start; i < end; i++) {
            sum += array[i];
        }

        return 800.0 * this.scale / sum;
    }

    calculate(messages, desiredWidth) {
        this.posArray = [];
        this.positions = new Map();
        this.messages = messages;

        if (!messages) return;
        const { length } = messages;
        if (length <= 1) {
            return;
        }

        this.totalWidth = 0;
        this.totalHeight = 0.0;

        this.scale = desiredWidth / this.maxSizeWidth;
        this.maxSizeWidth = desiredWidth;

        const firstSpanAdditionalSize = Math.trunc(200 * this.scale);
        const minHeight = Math.trunc(120 * this.scale);
        const minWidth = Math.trunc(96 * this.scale);
        const paddingsWidth = Math.trunc(32 * this.scale);
        const maxSizeHeight = 814.0 * this.scale;
        let averageAspectRatio = 1.0;
        let proportions = '';
        const isOut = false;
        let maxX = 0;
        let forceCalc = false;

        for (let i = 0; i < length; i++) {
            const message = messages[i];
            const { w, h } = GroupedMessages.getWidthHeightWithPhoto(message);

            const position = new GroupedMessagePosition();
            position.isLast = i === messages.length - 1;
            position.aspectRatio = w / h;
            if (position.aspectRatio > 1.2) {
                proportions += 'w';
            } else if (position.aspectRatio < 0.8) {
                proportions += 'n';
            } else {
                proportions += 'q';
            }

            averageAspectRatio += position.aspectRatio;
            if (position.aspectRatio > 2.0) {
                forceCalc = true;
            }

            this.positions.set(i, position);
            this.posArray.push(position);
        }

        const maxAspectRation = this.maxSizeWidth / maxSizeHeight;
        averageAspectRatio = averageAspectRatio / length;

        if (!forceCalc && (length === 2 || length === 3 || length === 4)){
            switch (length) {
                case 2: {
                    const position1 = this.posArray[0];
                    const position2 = this.posArray[1];

                    if (proportions === 'ww' && averageAspectRatio > 1.4 * maxAspectRation && position1.aspectRatio - position2.aspectRatio < 0.2) {
                        const height = Math.round(Math.min(this.maxSizeWidth / position1.aspectRatio, Math.min(this.maxSizeWidth / position2.aspectRatio, maxSizeHeight / 2.0))) / maxSizeHeight;
                        position1.set(0, 0, 0, 0, this.maxSizeWidth, height, POSITION_FLAG_LEFT | POSITION_FLAG_RIGHT | POSITION_FLAG_TOP);
                        position2.set(0, 0, 1, 1, this.maxSizeWidth, height, POSITION_FLAG_LEFT | POSITION_FLAG_RIGHT | POSITION_FLAG_BOTTOM);

                        this.totalWidth = this.maxSizeWidth;
                        this.totalHeight = height * 2;
                    } else if (proportions === 'ww' || proportions === 'qq') {
                        const width = this.maxSizeWidth / 2;
                        const height = Math.round(Math.min(width / position1.aspectRatio, Math.min(width / position2.aspectRatio, maxSizeHeight))) / maxSizeHeight;
                        position1.set(0, 0, 0, 0, width, height, POSITION_FLAG_LEFT | POSITION_FLAG_BOTTOM | POSITION_FLAG_TOP);
                        position2.set(1, 1, 0, 0, width, height, POSITION_FLAG_RIGHT | POSITION_FLAG_BOTTOM | POSITION_FLAG_TOP);
                        maxX = 1;

                        this.totalWidth = width + width;
                        this.totalHeight = height;
                    } else {
                        let secondWidth = Math.max(0.4 * this.maxSizeWidth, Math.round((this.maxSizeWidth / position1.aspectRatio / (1.0 / position1.aspectRatio + 1.0 / position2.aspectRatio))));
                        let firstWidth = this.maxSizeWidth - secondWidth;
                        if (firstWidth < minWidth) {
                            const diff = minWidth - firstWidth;
                            firstWidth = minWidth;
                            secondWidth -= diff;
                        }

                        const height = Math.min(maxSizeHeight, Math.round(Math.min(firstWidth / position1.aspectRatio, secondWidth / position2.aspectRatio))) / maxSizeHeight;
                        position1.set(0, 0, 0, 0, firstWidth, height, POSITION_FLAG_LEFT | POSITION_FLAG_BOTTOM | POSITION_FLAG_TOP);
                        position2.set(1, 1, 0, 0, secondWidth, height, POSITION_FLAG_RIGHT | POSITION_FLAG_BOTTOM | POSITION_FLAG_TOP);
                        maxX = 1;

                        this.totalWidth = firstWidth + secondWidth;
                        this.totalHeight = height;
                    }

                    break;
                }
                case 3: {
                    const position1 = this.posArray[0];
                    const position2 = this.posArray[1];
                    const position3 = this.posArray[2];
                    if (proportions[0] === 'n')
                    {
                        const thirdHeight = Math.min(maxSizeHeight * 0.5, Math.round(position2.aspectRatio * this.maxSizeWidth / (position3.aspectRatio + position2.aspectRatio)));
                        const secondHeight = maxSizeHeight - thirdHeight;
                        const rightWidth = Math.max(minWidth, Math.min(this.maxSizeWidth * 0.5, Math.round(Math.min(thirdHeight * position3.aspectRatio, secondHeight * position2.aspectRatio))));

                        const leftWidth = Math.round(Math.min(maxSizeHeight * position1.aspectRatio + paddingsWidth, this.maxSizeWidth - rightWidth));
                        position1.set(0, 0, 0, 1, leftWidth, 1.0, POSITION_FLAG_LEFT | POSITION_FLAG_BOTTOM | POSITION_FLAG_TOP);
                        position2.set(1, 1, 0, 0, rightWidth, secondHeight / maxSizeHeight, POSITION_FLAG_RIGHT | POSITION_FLAG_TOP);
                        position3.set(0, 1, 1, 1, rightWidth, thirdHeight / maxSizeHeight, POSITION_FLAG_RIGHT | POSITION_FLAG_BOTTOM);
                        position3.spanSize = this.maxSizeWidth;

                        position1.siblingHeights = [thirdHeight / maxSizeHeight, secondHeight / maxSizeHeight];

                        if (isOut) {
                            position1.spanSize = this.maxSizeWidth - rightWidth;
                        } else {
                            position2.spanSize = this.maxSizeWidth - leftWidth;
                            position3.leftSpanOffset = leftWidth;
                        }
                        this.hasSibling = true;
                        maxX = 1;

                        this.totalWidth = leftWidth + rightWidth;
                        this.totalHeight = 1.0;
                    }
                    else
                    {
                        const firstHeight = Math.round(Math.min(this.maxSizeWidth / position1.aspectRatio, (maxSizeHeight) * 0.66)) / maxSizeHeight;
                        position1.set(0, 1, 0, 0, this.maxSizeWidth, firstHeight, POSITION_FLAG_LEFT | POSITION_FLAG_RIGHT | POSITION_FLAG_TOP);

                        const width = this.maxSizeWidth / 2;
                        const secondHeight = Math.min(maxSizeHeight - firstHeight, Math.round(Math.min(width / position2.aspectRatio, width / position3.aspectRatio))) / maxSizeHeight;
                        position2.set(0, 0, 1, 1, width, secondHeight, POSITION_FLAG_LEFT | POSITION_FLAG_BOTTOM);
                        position3.set(1, 1, 1, 1, width, secondHeight, POSITION_FLAG_RIGHT | POSITION_FLAG_BOTTOM);
                        maxX = 1;

                        this.totalWidth = this.maxSizeWidth;
                        this.totalHeight = firstHeight + secondHeight;
                    }

                    break;
                }
                case 4: {
                    const position1 = this.posArray[0];
                    const position2 = this.posArray[1];
                    const position3 = this.posArray[2];
                    const position4 = this.posArray[3];
                    if (proportions[0] === 'w') {
                        const h0 = Math.round(Math.min(this.maxSizeWidth / position1.aspectRatio, maxSizeHeight * 0.66)) / maxSizeHeight;
                        position1.set(0, 2, 0, 0, this.maxSizeWidth, h0, POSITION_FLAG_LEFT | POSITION_FLAG_RIGHT | POSITION_FLAG_TOP);

                        let h = Math.round(this.maxSizeWidth / (position2.aspectRatio + position3.aspectRatio + position4.aspectRatio));
                        const w0 = Math.max(minWidth, Math.min(this.maxSizeWidth * 0.4, h * position2.aspectRatio));
                        const w2 = Math.max(Math.max(minWidth, this.maxSizeWidth * 0.33), h * position4.aspectRatio);
                        const w1 = this.maxSizeWidth - w0 - w2;
                        h = Math.min(maxSizeHeight - h0, h);
                        h /= maxSizeHeight;
                        position2.set(0, 0, 1, 1, w0, h, POSITION_FLAG_LEFT | POSITION_FLAG_BOTTOM);
                        position3.set(1, 1, 1, 1, w1, h, POSITION_FLAG_BOTTOM);
                        position4.set(2, 2, 1, 1, w2, h, POSITION_FLAG_RIGHT | POSITION_FLAG_BOTTOM);
                        maxX = 2;

                        this.totalWidth = this.maxSizeWidth;
                        this.totalHeight = h0 + h;
                    } else {
                        const w = Math.max(minWidth, Math.round(maxSizeHeight / (1.0 / position2.aspectRatio + 1.0 / position3.aspectRatio + 1.0 / position4.aspectRatio)));
                        const h0 = Math.min(0.33, Math.max(minHeight, w / position2.aspectRatio) / maxSizeHeight);
                        const h1 = Math.min(0.33, Math.max(minHeight, w / position3.aspectRatio) / maxSizeHeight);
                        const h2 = 1.0 - h0 - h1;
                        const w0 = Math.round(Math.min(maxSizeHeight * position1.aspectRatio + paddingsWidth, this.maxSizeWidth - w));

                        position1.set(0, 0, 0, 2, w0, h0 + h1 + h2, POSITION_FLAG_LEFT | POSITION_FLAG_TOP | POSITION_FLAG_BOTTOM);
                        position2.set(1, 1, 0, 0, w, h0, POSITION_FLAG_RIGHT | POSITION_FLAG_TOP);
                        position3.set(0, 1, 1, 1, w, h1, POSITION_FLAG_RIGHT);
                        position3.spanSize = this.maxSizeWidth;
                        position4.set(0, 1, 2, 2, w, h2, POSITION_FLAG_RIGHT | POSITION_FLAG_BOTTOM);
                        position4.spanSize = this.maxSizeWidth;

                        if (isOut) {
                            position1.spanSize = this.maxSizeWidth - w;
                        } else {
                            position2.spanSize = this.maxSizeWidth - w0;
                            position3.leftSpanOffset = w0;
                            position4.leftSpanOffset = w0;
                        }
                        position1.siblingHeights = [ h0, h1, h2 ];
                        this.hasSibling = true;
                        maxX = 1;

                        this.totalWidth = w + w0;
                        this.totalHeight = h0 + h1 + h2;
                    }
                    break;
                }
            }
        } else {
            const croppedRatios = new Array(this.posArray.length);
            for (let i = 0; i < length; i++) {
                if (averageAspectRatio > 1.1) {
                    croppedRatios[i] = Math.max(1.0, this.posArray[i].aspectRatio);
                } else {
                    croppedRatios[i] = Math.min(1.0, this.posArray[i].aspectRatio);
                }
                croppedRatios[i] = Math.max(0.66667, Math.min(1.7, croppedRatios[i]));
            }

            let firstLine;
            let secondLine;
            let thirdLine;
            let fourthLine;
            const attempts = [];
            for (firstLine = 1; firstLine < croppedRatios.length; firstLine++) {
                secondLine = croppedRatios.length - firstLine;
                if (firstLine > 3 || secondLine > 3) {
                    continue;
                }
                attempts.push(new MessageGroupedLayoutAttempt([firstLine, secondLine], [this.multiHeight(croppedRatios, 0, firstLine), this.multiHeight(croppedRatios, firstLine, croppedRatios.length)]));
            }

            for (firstLine = 1; firstLine < croppedRatios.length - 1; firstLine++) {
                for (secondLine = 1; secondLine < croppedRatios.length - firstLine; secondLine++) {
                    thirdLine = croppedRatios.length - firstLine - secondLine;
                    if (firstLine > 3 || secondLine > (averageAspectRatio < 0.85 ? 4 : 3) || thirdLine > 3) {
                        continue;
                    }
                    attempts.push(new MessageGroupedLayoutAttempt([firstLine, secondLine, thirdLine], [this.multiHeight(croppedRatios, 0, firstLine), this.multiHeight(croppedRatios, firstLine, firstLine + secondLine), this.multiHeight(croppedRatios, firstLine + secondLine, croppedRatios.length)]));
                }
            }

            for (firstLine = 1; firstLine < croppedRatios.length - 2; firstLine++) {
                for (secondLine = 1; secondLine < croppedRatios.length - firstLine; secondLine++) {
                    for (thirdLine = 1; thirdLine < croppedRatios.length - firstLine - secondLine; thirdLine++) {
                        fourthLine = croppedRatios.length - firstLine - secondLine - thirdLine;
                        if (firstLine > 3 || secondLine > 3 || thirdLine > 3 || fourthLine > 3) {
                            continue;
                        }
                        attempts.push(new MessageGroupedLayoutAttempt([firstLine, secondLine, thirdLine, fourthLine], [this.multiHeight(croppedRatios, 0, firstLine), this.multiHeight(croppedRatios, firstLine, firstLine + secondLine), this.multiHeight(croppedRatios, firstLine + secondLine, firstLine + secondLine + thirdLine), this.multiHeight(croppedRatios, firstLine + secondLine + thirdLine, croppedRatios.length)]));
                    }
                }
            }

            let optimal = null;
            let optimalDiff = 0.0;
            let maxHeight = this.maxSizeWidth / 3 * 4;
            for (let i = 0; i < attempts.length; i++) {
                const attempt = attempts[i];
                let height = 0;
                let minLineHeight = Number.MAX_VALUE;
                for (let j = 0; j < attempt.heights.length; j++) {
                    height += attempt.heights[j];
                    if (attempt.heights[j] < minLineHeight) {
                        minLineHeight = attempt.heights[j];
                    }
                }

                let diff = Math.abs(height - maxHeight);
                if (attempt.lineCounts.length > 1) {
                    if (attempt.lineCounts[0] > attempt.lineCounts[1] || (attempt.lineCounts.length > 2 && attempt.lineCounts[1] > attempt.lineCounts[2]) || (attempt.lineCounts.length > 3 && attempt.lineCounts[2] > attempt.lineCounts[3])) {
                        diff *= 1.5;
                    }
                }

                if (minLineHeight < minWidth) {
                    diff *= 1.5;
                }

                if (optimal === null || diff < optimalDiff) {
                    optimal = attempt;
                    optimalDiff = diff;
                }
            }

            if (optimal === null) {
                return;
            }

            let index = 0;
            let y = 0.0;

            for (let i = 0; i < optimal.lineCounts.length; i++) {
                let c = optimal.lineCounts[i];
                let lineHeight = optimal.heights[i];
                let spanLeft = this.maxSizeWidth;
                let posToFix = null;
                maxX = Math.max(maxX, c - 1);
                for (let j = 0; j < c; j++) {
                    let ratio = croppedRatios[index];
                    let width = Math.trunc(ratio * lineHeight);
                    spanLeft -= width;
                    let pos = this.posArray[index];
                    let flags = 0;
                    if (i === 0) {
                        flags |= POSITION_FLAG_TOP;
                    }
                    if (i === optimal.lineCounts.length - 1) {
                        flags |= POSITION_FLAG_BOTTOM;
                    }
                    if (j === 0) {
                        flags |= POSITION_FLAG_LEFT;
                        if (isOut) {
                            posToFix = pos;
                        }
                    }
                    if (j === c - 1) {
                        flags |= POSITION_FLAG_RIGHT;
                        if (!isOut) {
                            posToFix = pos;
                        }
                    }
                    pos.set(j, j, i, i, width, lineHeight / maxSizeHeight, flags);
                    index++;
                }
                posToFix.width += spanLeft;
                posToFix.spanSize += spanLeft;
                y += lineHeight;
            }

            this.totalWidth = this.maxSizeWidth;
            this.totalHeight = y / maxSizeHeight;
        }
        // debugger;
    }

    static getWidthHeightWithPhoto(sizes) {
        let w = 0;
        let h = 0;
        const photoSize = GroupedMessages.getPhotoSize(sizes, 1280);
        if (photoSize) {
            w = photoSize.width;
            h = photoSize.height;
        }

        return { w, h };
    }

    static getWidthHeight(message) {
        let w = 0;
        let h = 0;
        let sizes = [];
        switch (message.content['@type']){
            case 'messagePhoto': {
                const { photo, minithumbnail } = message.content;
                if (photo) {
                    sizes = photo.sizes;
                } else if (minithumbnail) {
                    sizes.push(minithumbnail);
                }

                break;
            }
            case 'messageVideo': {
                const { video, thumbnail, minithumbnail } = message.content;
                if (video) {
                    const { width, height } = video;
                    sizes.push({ width, height });
                } else if (minithumbnail) {
                    sizes.push(minithumbnail);
                } else if (thumbnail) {
                    sizes.push(thumbnail);
                }

                break;
            }
            case 'messageDocument': {
                const { thumbnail, minithumbnail } = message.content;
                if (minithumbnail) {
                    sizes.push(minithumbnail);
                } else if (thumbnail) {
                    sizes.push(thumbnail);
                } else {
                    sizes.push({ width: 90, height: 90 });
                }

                break;
            }
        }

        const photoSize = GroupedMessages.getPhotoSize(sizes, 1280);
        if (photoSize) {
            w = photoSize.width;
            h = photoSize.height;
        }

        return { w, h };
    }

    static getPhotoSize(sizes, side, byMinSize) {
        if (!sizes || !sizes.length) return null;

        let lastSide = 0;
        let lastSize = null;
        for (let i = 0; i < sizes.length; i++) {
            const { width: w, height: h } = sizes[i];

            if (byMinSize) {
                const currentSide = h >= w ? w : h;
                if (!lastSize || (side > 100 && side > lastSide && lastSide < currentSide)) {
                    lastSide = currentSide;
                    lastSize = sizes[i];
                }

            } else {
                const currentSide = w >= h ? w : h;
                if (!lastSize || (side > 100 && currentSide <= side && lastSide < currentSide)) {
                    lastSide = currentSide;
                    lastSize = sizes[i];
                }
            }
        }

        return lastSize;
    }
}



// 定义公共函数 下划线切割

/**
 * 获取照片组单张照片宽高
 * @param photos
 */
function getPhotoWidthHeight(photos,showWidth = 380)
{
    let WidthHeight = []
    let grouped = new GroupedMessages()
    grouped.calculate(photos,showWidth)
    console.log(grouped.positions)
    for(let i =0;i<photos.length ;i++){
        WidthHeight.push(grouped.positions.get(i))
    }
    return WidthHeight
}

/**
 * 获取设置的值
 *
 * @param name
 * @param defaultValue
 * @returns {*}
 */
function setting(name, defaultValue)
{
    if(room_setting.hasOwnProperty(name)){
        return room_setting[name]
    }
    return defaultValue
}

/**
 * 获取用户信息
 *
 * @param name
 * @param defaultValue
 * @returns {*}
 */
function get_user(name, defaultValue)
{
    let user = JSON.parse(localStorage.getItem('user'))
    if(user.hasOwnProperty(name)){
        return user[name];
    }
    return defaultValue;
}

/**
 * 设置用户信息
 *
 * @param user
 */
function set_user(user)
{
    localStorage.setItem('user', JSON.stringify(user))
}


let new_notify_audio = null;
function play_new_notify()
{
    new_notify_audio = new Audio('/audio/message-notice.mp3');
    new_notify_audio.play();
}

/**
 * 检测是否是手机模式
 * @returns {boolean}
 */
function mobile_check() {
    let check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};


/**
 * 安全的BASE64编码
 * @param text
 * @returns {string}
 */
function base64_safe_encode(text)
{
    text = window.btoa(text)
    return text
}


/**
 * 插入光标至末尾
 * @param el
 */
function place_caret_at_end(el) {
    el.focus();
    if (typeof window.getSelection != "undefined"
        && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    }
    else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}

/**
 * 保存访客信息
 */
function session_save_name(){
    let remark_text = $("#profile-remark-text").val();
    let your_name = $("#profile-your-name").val();
    $.post('/api/room/set_user',{
        remark:remark_text,
        name:your_name,
    },function(res){
        localStorage.setItem('user',JSON.stringify({
            name:your_name,
            remark:remark_text,
            uuid:res.data.uuid
        }))
        $('#perfect-profile-modal').modal('hide')
    })

}

/**
 * 发送文本消息
 * @param text
 */
function send_message(text)
{
    let user = JSON.parse(localStorage.getItem('user'))
    let uuid = user.uuid
    let _msg_id = base64_safe_encode(Date.now()+Math.random());
    let messages = [
        {
            message_text:text,
            media_type:0,
            from_name:user.name,
            from_user_id:1,
            to_user_id:0,
            id:0,
            '_msg_id':_msg_id
        }
    ];
    let html = template('tpl-message', {
        list: messages,
        mobile_check:mobile_check,
        setting:setting,
        get_user:get_user,
    });
    $('#rom').append(html);
    $('.room-content').scrollTop($('.lite-chatbox').height())
    $('.composer_rich_textarea ').html('')

    message_request_ids.push(_msg_id);
    $.post('/api/room/message/new',{
        text:text,
        uuid:uuid,
        request_id:_msg_id
    },function(res){
        let id = res.data.id;
        last_id = id;
        document.getElementById('_msg_id_'+_msg_id).remove()
        console.log(res)
    })
    filter_element('.message-media-video').appear();
}


/**
 * 发送图文信息
 *
 * @param text
 * @param media
 */
function send_message_with_photo(text,media)
{
    let user = JSON.parse(localStorage.getItem('user'))
    let uuid = user.uuid
    let _msg_id = base64_safe_encode(Date.now()+Math.random());
    let messages = [
        {
            message_text: text,
            media: media.media,
            media_type: 1,
            media_width: media.media_width,
            media_height: media.media_height,
            from_name: user.name,
            from_user_id: 1,
            to_user_id: 0,
            id: 0,
            '_msg_id': _msg_id
        }
    ];
    console.log(messages)
    let html = template('tpl-message', {
        list: messages,
        mobile_check:mobile_check,
        setting:setting,
        get_user:get_user,
    });
    $('#rom').append(html);
    $('.room-content').scrollTop($('.lite-chatbox').height())
    $('.composer_rich_textarea ').html('')

    message_request_ids.push(_msg_id);

    let blob = data_url_to_blob(media.media);
    let file = media.media = blog_to_file(blob, Date.now());
    var formData = new FormData();
    formData.append('file', file);
    $.ajax({
        url: "/upload/img",
        type: "post",
        data: formData,
        contentType: false,
        processData: false,
        mimeType: "multipart/form-data",
        success: function (data) {
            try{
                data = JSON.parse(data)
                $.post('/api/room/message/new',{
                    text:text,
                    media:data.data.url,
                    uuid:uuid,
                    request_id:_msg_id
                },function(res){
                    let id = res.data.id;
                    last_id = id;
                    document.getElementById('_msg_id_'+_msg_id).remove()
                    console.log(res)
                })
            }catch (e) {
                console.log("upload fail",e)
                return
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function send_message_with_photos(messages)
{

}


function render_messages(origin_messages)
{
    let messages = []
    console.log(origin_messages)
    for(let i =0;i<origin_messages.length;i++){
        const message = origin_messages[i];
        const {id,message_id,media_type,message_text,media_group_id} = message
        if(parseInt(media_group_id) !== 0 && parseInt(media_type) === MEDIA_PHOTO){
            const album = [message];
            for(let j = i+1; j<i+ALBUM_MESSAGES_LIMIT && j<origin_messages.length;j++){
                if(origin_messages[j].media_group_id === media_group_id){
                    album.push(origin_messages[j]);
                }else{
                    break
                }
            }

            if(album.length > 1){
                let param = []
                album.map( x=> param.push([{
                    width:x.media_width,
                    height:x.media_height
                }]))
                const show_width = Math.min($('.room-content').width() - 150,380);

                message.album = album
                message.position = getPhotoWidthHeight(param,show_width)
                console.log(show_width)
                console.log(message.position)
                console.log(message.album)
                message.show_width = show_width

                message.media_type = 1
                messages.push(message)
                i += (album.length - 1);
            }else{
                messages.push(message)
            }
        }else{
            messages.push(message)
        }
    }

    let html = template('tpl-message2', {
        list: messages,
        mobile_check:mobile_check,
        setting:setting,
        get_user:get_user,
    });
    $('#rom').append(html);
}


let last_id = 0;

/**
 * 获取所有历史消息
 */
function get_messages()
{
    let user = JSON.parse(localStorage.getItem('user'))
    let uuid = user.uuid
    $.get('/api/room/message?uuid='+uuid, function(res){
        if(res.code != 200){
            return;
        }
        let messages = [];
        for(let i in res.data.messages){
            if(res.data.messages[i].request_id != ''){
                if(message_request_ids.indexOf(res.data.messages[i].request_id) != -1){
                    continue;
                }
            }
            messages.push(res.data.messages[i])
        }
        if(messages.length>0){
            last_id = res.data.last_id;
        }
        render_messages(messages)
        // let html = template('tpl-message', {
        //     list: messages,
        //     mobile_check:mobile_check,
        //     setting:setting,
        //     get_user:get_user,
        // });
        // $('#rom').append(html);


        // if (is_first) {
        //     is_first = false;
        //     $('.room-content').scrollTop($('.lite-chatbox').height())
        //     // $('.lite-chatbox').scrollTop($('.lite-chatbox').height()+$('.lite-chatbox').offset().top);
        // }
        // $('.room-content').scrollTop($('.lite-chatbox').height())
        $('.room-content').scrollTop($('.room-content')[0].scrollHeight)

        // 这里需要过滤，否则会出现一个元素动态绑定两次的情况
        filter_element('.message-media-video').appear();
    })
}


let pull_message_lock = false;

/**
 * 拉取新消息
 * @returns {boolean}
 */
function pull_message()
{
    if(pull_message_lock){
        return false;
    }
    pull_message_lock = true;
    let user = JSON.parse(localStorage.getItem('user'))
    let uuid = user.uuid
    $.get('/api/room/message?uuid='+uuid+'&last_id='+last_id, function(res){
        if(res.code != 200){
            return;
        }
        let messages = [];
        for(let i in res.data.messages){
            if(res.data.messages[i].request_id != ''){
                if(message_request_ids.indexOf(res.data.messages[i].request_id) != -1){
                    continue;
                }
            }
            messages.push(res.data.messages[i])
        }
        if(messages.length>0){
            last_id = res.data.last_id;
            play_new_notify() // 播放消息提醒
        }

        let scrollUpdate = false;
        if($('.lite-chatbox').height()-($('.room-content').scrollTop()+$('.room-content').height()) < 10){
            scrollUpdate = true
        }

        render_messages(messages)
        // let html = template('tpl-message2', {
        //     list: messages,
        //     mobile_check:mobile_check,
        //     setting:setting,
        //     get_user:get_user,
        // });
        // $('#rom').append(html);
        pull_message_lock = false;
        if(scrollUpdate){
            $('.room-content').scrollTop($('.lite-chatbox').height())
        }

        filter_element('.message-media-video').appear();
    })
}

/**
 * 过滤元素
 * 每次获取只能获取未标记的元素，每次获取都将标记元素，二次获取不到
 * @param element
 * @returns {*|jQuery|HTMLElement}
 */
function filter_element(element)
{
    let result = $(element+'[filter-event-video!=1]')
    result.each(function(){
        if(!$(this).attr('filter-event-video')){
            $(this).attr('filter-event-video', 1)
        }
    })
    return result
}

// 执行初始化变量
let message_request_ids = [];
let is_first = true;

// 页面加载监听方法
$(document.body).on('appear', '.message-media-video', function(e, $affected) {
    $(e.currentTarget).find('video')[0].currentTime = 0
    $(e.currentTarget).find('video')[0].play()
    // console.log($(e.currentTarget).find('video')[0],'播放')
});
$(document.body).on('disappear', '.message-media-video', function(e, $affected) {
    $(e.currentTarget).find('video')[0].pause()
    $(e.currentTarget).find('video')[0].currentTime = 0
    // console.log($(e.currentTarget).find('video')[0],'停止')
});
$('.room-content').scroll(function(){
    $.force_appear();
})

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * 监听回车键发送消息和shift回车还行
 */
$('.composer_rich_textarea').keydown(function(e){
    if(e.keyCode == 13 && !e.shiftKey){
        //按下了enter键，发送消息
        let message = $('.composer_rich_textarea ').text()
        send_message(message)
        e.preventDefault();
        return false;
    }
    if(e.shiftKey && e.keyCode == 13){
        var content=$('.composer_rich_textarea ').html();
        $('.composer_rich_textarea ').html(content+"<div><br/></div>");
        place_caret_at_end($('.composer_rich_textarea ').get(0))
        return false;
    }
})

/**
 * 完善资料模态框被打开
 */
$('#perfect-profile-modal').on('show.bs.modal', function (event) {
    var modal = $(this)
    // modal.find('.modal-title').text('New message to ' + recipient)
    // modal.find('.modal-body input').val(recipient)
})

/**
 * 聊天室资料页模态框被打开
 */
$('#about-room-profile-modal').on('show.bs.modal', function (event) {
    var modal = $(this)
    if(setting('room_name')){
        modal.find('#about-room-profile-avatar').attr('src', setting('room_avatar','/avatar/default.jpg'))
        modal.find('#about-room-profile-name').text(setting('room_name', '未知的聊天室'))
        modal.find('#about-room-profile-desc').text(setting('room_desc', ''))
    }else{
        return false;
    }

})

/**
 * 个人资料模态框被打开
 */
$('#about-me-profile-modal').on('show.bs.modal', function (event) {
    var modal = $(this)
    let user = JSON.parse(localStorage.getItem('user'))
    if(user && user.name && user.name !=''){
        modal.find('#about-me-profile-avatar').attr('src', user.avatar ? user.avatar : '/avatar/default.jpg')
        modal.find('#about-me-profile-name').text(user.name ? user.name : '未知的名字')
        modal.find('#about-me-profile-desc').text(user.remark ? user.remark : '')
    }else{
        return false;
    }
    // modal.find('.modal-body input').val(recipient)
})

/**
 * 文件上传变更事件
 */
$("#file").change(function (e) {
    var file = e.target.files[0] || e.dataTransfer.files[0];
    let a = document.getElementById("file").files[0].name
    console.log(a)
    if (file) {
        $('#upload-photo-preview-modal').modal({
            keyboard:false,
            backdrop:false,
            show:true
        })
        var reader = new FileReader();
        let images = []
        reader.onload = function (e2) {
            let img = document.createElement('img');
            img.src= e2.target.result;
            img.onload = function(){
                images.push(
                    {
                        img: e2.target.result,
                        width:this.width,
                        height:this.height
                    }
                )
                renderEditorPhotos(images)
            }

        }
        reader.readAsDataURL(file);

        // var file = document.getElementById("file").files[0];
        // var formData = new FormData();
        // formData.append('file', file);
        // $.ajax({
        //     url: "/upload/img",
        //     type: "post",
        //     data: formData,
        //     contentType: false,
        //     processData: false,
        //     mimeType: "multipart/form-data",
        //     success: function (data) {
        //         try{
        //             data = JSON.parse(data)
        //             $('#upload-photo-preview-img').data('upload-url',data.data.url);
        //         }catch (e) {
        //             console.log("upload fail",e)
        //             return
        //         }
        //     },
        //     error: function (data) {
        //         console.log(data);
        //     },
        //     xhr:function(){
        //         var jqXHR = null;
        //         if ( window.ActiveXObject )
        //         {
        //             jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
        //         }
        //         else
        //         {
        //             jqXHR = new window.XMLHttpRequest();
        //         }
        //
        //         //Upload progress
        //         jqXHR.upload.addEventListener( "progress", function ( evt )
        //         {
        //             if ( evt.lengthComputable )
        //             {
        //                 var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
        //                 //Do something with upload progress
        //                 $('#upload-photo-preview-progress').css('width',percentComplete+'%')
        //                 $('#upload-photo-preview-progress').text(percentComplete+'%')
        //                 console.log( 'Uploaded percent', percentComplete );
        //             }
        //         }, false );
        //
        //         //Download progress
        //         jqXHR.addEventListener( "progress", function ( evt )
        //         {
        //             if ( evt.lengthComputable )
        //             {
        //                 var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
        //                 //Do something with download progress
        //                 console.log( 'Downloaded percent', percentComplete );
        //             }
        //         }, false );
        //
        //         return jqXHR;
        //     }
        // });
    }
});

var dropZone = document.querySelector('.room-content');

// Optional.   Show the copy icon when dragging over.  Seems to only work for chrome.
dropZone.addEventListener('dragover', function(e) {
    e.stopPropagation();
    e.preventDefault();
    e.dataTransfer.dropEffect = 'copy';
});

// Get file data on drop
dropZone.addEventListener('drop', function(e) {
    e.stopPropagation();
    e.preventDefault();

    var files = e.dataTransfer.files; // Array of all files
console.log('=============')
console.log(files)

    let images = []
    let imagesLength = files.length
    for (var i=0, file; file=files[i]; i++) {
        if (file.type.match(/image.*/)) {
            var reader = new FileReader();

            reader.onload = function(e2) {
                // finished reading file data.
                let img = document.createElement('img');
                img.src= e2.target.result;
                img.onload = function(){
                    images.push(
                        {
                            img: e2.target.result,
                            width:this.width,
                            height:this.height
                        }
                    )
                    if(images.length === imagesLength ){
                        renderEditorPhotos(images)
                        console.log(images)
                    }
                }
                // document.body.appendChild(img);
            }
            reader.readAsDataURL(file); // start reading the file data.
            continue

            var formData = new FormData();
            formData.append('file', file);
            $.ajax({
                url: "/upload/img",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                success: function (data) {
                    try{
                        data = JSON.parse(data)
                        console.log(data)
                    }catch (e) {
                        console.log("upload fail",e)
                        return
                    }
                },
                error: function (data) {
                    console.log(data);
                },
            });

        }
    }

});


/**
 * 打开上传文件按钮
 */
function open_file_to_upload()
{
    $("#file").click()
}

/**
 * dataURL to Blob
 * @param dataurl
 * @returns {Blob}
 */
function data_url_to_blob(dataurl) {
    let arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);
    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new Blob([u8arr], { type: mime });
}
//将blob转换为file
function blog_to_file(theBlob, fileName){
    theBlob.lastModifiedDate = new Date();
    theBlob.name = fileName;
    return theBlob;
}

/**
 * 发送图片事件
 */
function send_photo_event()
{
    if (wait_upload_images.length === 0) return;
    const message_text = $('#upload-photo-preview-caption').val()

    if(wait_upload_images.length >1){
        let param = []
        wait_upload_images.map( x=> param.push([x]))
        const show_width = Math.min($('.room-content').width() - 150,380);
        let position = getPhotoWidthHeight(param,show_width)
        let user = JSON.parse(localStorage.getItem('user'))
        let uuid = user.uuid
        let _msg_id = base64_safe_encode(Date.now()+Math.random());
        let album = []
        wait_upload_images.map( x=> album.push({
            media: x.img,
            media_width: x.width,
            media_height: x.height,
            media_type: MEDIA_PHOTO,
        }))
        let messages = [
            {
                message_text: message_text,
                album:album,
                photos:wait_upload_images,
                position:position,
                show_width:show_width,

                media_type: 1,
                from_name: user.name,
                from_user_id: 1,
                to_user_id: 0,
                id: 0,
                '_msg_id': _msg_id
            }
        ];
        let html = template('tpl-message2', {
            list: messages,
            mobile_check:mobile_check,
            setting:setting,
            get_user:get_user,
        });
        $('#rom').append(html);

        $('#upload-photo-preview-modal').modal('hide')

        // 上传图片
        console.log(wait_upload_images)
        let upload_done  = []
        wait_upload_images.map(x => {
            let blob = data_url_to_blob(x.img);
            let file = blog_to_file(blob, Date.now());

            let formData = new FormData();
            formData.append('file', file);
            $.ajax({
                url: "/upload/img",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                success: function (data) {
                    try{
                        data = JSON.parse(data)
                        upload_done.push(data.data.url)
                        x.url = data.data.url
                        if(upload_done.length === wait_upload_images.length ){
                            // send_message_with_photos(messages)

                            console.log('==================')
                            console.log(wait_upload_images)

                            message_request_ids.push(_msg_id);
                            let media = []
                            wait_upload_images.map( x=> {
                                media.push({
                                    height:x.height,
                                    width:x.width,
                                    url:x.url,
                                })
                            })
                            $.post('/api/room/message/new',{
                                text:message_text,
                                media:media,
                                uuid:uuid,
                                request_id:_msg_id
                            },function(res){
                                let id = res.data.id;
                                last_id = id;
                                document.getElementById('_msg_id_'+_msg_id).remove()
                                console.log(res)
                            })
                        }
                        console.log(data)
                    }catch (e) {
                        console.log("upload fail",e)
                        return
                    }
                },
                error: function (data) {
                    console.log(data);
                },
            });
        })

    }else{
        let photo = wait_upload_images[0]
        if(!photo.length === 0){
            console.log('未获得photo上传地址')
            return false;
        }
        // let blob = data_url_to_blob(photo.img);
        // let file = blog_to_file(blob, Date.now());
        let media = {
            media: photo.img,
            media_width: photo.width,
            media_height: photo.height,
            media_type: 1,
        }

        send_message_with_photo(message_text,media)
        $('#upload-photo-preview-modal').modal('hide')
    }


}

/**
 * 判断用户访客是否登记信息
 * 如果没有需要先进行完善资料
 */
try{
    let user = JSON.parse(localStorage.getItem('user'))
    if(!user || !user.name || user.name ==''){
        $('#perfect-profile-modal').modal({keyboard:false,backdrop:false,show:true})
    }else{
        get_messages();
        setInterval(function(){
            pull_message();
        },1000*2);
    }
}catch (e) {

}


// tests
// $('#about-room-profile-modal').modal('show')
// $('#upload-photo-preview-modal').modal('show')

let wait_upload_images = []
function renderEditorPhotos(photos)
{
    $('#upload-photo-preview-modal').modal('show')
    wait_upload_images = photos
    if(photos.length >1){
        // getPhotoWidthHeight([[{width:1280,height:720}],[{width:1280,height:720}]])
        let show_width = $('#upload-photo-preview-modal .modal-content').width() - 32
        let param = []
        photos.map( x=> param.push([x]))
        let position = getPhotoWidthHeight(param,show_width)
        $('.preview-flex-photos').replaceWith(template('tpl-photos',{
            position: position,
            photos:photos,
            show_width:show_width
        }))
    }else{
        $('.preview-flex-photos').replaceWith(template('tpl-photos',{
            photos:photos,
        }))
    }
}
renderEditorPhotos([
    {
        img:'/img/1.jpg',
        width:1280,
        height:720
    },
    {
        img:'/img/2.jpg',
        width:957,
        height:1280
    },
    {
        img:'/img/3.jpg',
        width:1067,
        height:1280
    },
    {
        img:'/img/4.jpg',
        width:814,
        height:1280
    },
    {
        img:'/img/5.jpg',
        width:1280,
        height:1061
    },
])

// renderEditorPhotos([
//
//     {
//         img:'/img/2.jpg',
//         width:957,
//         height:1280
//     },
//     {
//         img:'/img/1.jpg',
//         width:1280,
//         height:720
//     },
//     {
//         img:'/img/3.jpg',
//         width:1067,
//         height:1280
//     },
// ])
