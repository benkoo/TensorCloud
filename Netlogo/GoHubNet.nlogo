;; create a breed of turtles that the participants control through the clients
;; there will be one participant for each client.
breed [participants participant]
breed [boardspaces boardspace]
breed [whitepieces whitepiece]
breed [blackpieces blackpiece]

;; Note that once you created certain breed of links, all links must be given a special breed.
undirected-link-breed [lineLinks lineLink]
;;These are special types of links between white and black pieces of chess.
undirected-link-breed [white-links white-link]
undirected-link-breed [black-links black-link]


globals [
  participant_list
  mouse-clicked?
  isBlack?
  num_lines
  currentNumberOfLinkedPieces
  koX koY
  move_list
  current_move
  isNewMove?
  GAME_FILE_NAME
]

participants-own
[
  user-id    ;; Participant choose a user name when they log in whenever you receive a
             ;; message from the participant associated with this turtle hubnet-message-source
             ;; will contain the user-id

  participant-count    ;; The number of participants.

  xLoc       ;; The most recent chess placement location on the x axis.

  yLoc       ;; The most recent chess placement location on the y axis.
]

;; the STARTUP procedure runs only once at the beginning of the model
;; at this point you must initialize the system.
to startup
  hubnet-reset
end

to setup
  clear-all
  clear-patches
  clear-drawing
  clear-output

  set participant_list []
  set move_list []
  set current_move []

  set isNewMove? false
  remove-participant
  ;; during setup you do not want to kill all the turtles
  ;; (if you do you'll lose any information you have about the clients)
  ;; so reset any variables you want to default values, and let the clients
  ;; know about the change if the value appears anywhere in their interface.

  ;; calling reset-ticks enables the 'go' button
  reset-ticks

  ;;Start the Go implementation
  set isBlack? true
  set num_lines 19 ;; Set the chess board to have num_lines * num_lines lines
  resize-world 0 (num_lines - 1) 0 (num_lines - 1)
  set currentNumberOfLinkedPieces 0
  set koX -1
  set koY -1

  ;;Draw the grid
  drawXYGrid
end

;; Draw XY Grid
to drawXYGrid
  ask patches [
    sprout-boardspaces 1 [
      set color white
      set shape "circle"
      set size 0
    ]
  ]

  ask turtles [
    create-lineLinks-with other turtles with [distance myself = 1] [
      set thickness 0.07
    ]
  ]

  ask participants [
    set size 0
  ]
end


to go
  ;; process incoming messages and respond to them (if needed)
  ;; listening for messages outside of the every block means that messages
  ;; get processed and responded to as fast as possible
  listen-clients

  if (not empty? current_move) and (isNewMove?)[
    let mX item 0 current_move
    let mY item 1 current_move
    let chessColor item 2 current_move

    if (canDealHand? mX mY isBlack?) and isNewMove? [
      set koX -1
      set koY -1

      let deadChessList (findEnemyPiecesForKill mX mY isBlack?)

      if 1 = length deadChessList [
        let aChess last deadChessList
        set koX [xcor] of aChess
        set koY [ycor] of aChess
      ]

      foreach deadChessList [ aChess ->
        ask aChess [
          die
        ]
      ]

      ifelse isBlack?[
        create-blackpieces 1 [
          dealOneHandofChessWithXY mX mY chessColor
          set isBlack? false
          set isNewMove? false
        ]
      ][
        create-whitepieces 1 [
          dealOneHandofChessWithXY mX mY chessColor
          set isBlack? true
          set isNewMove? false
        ]
      ]

      set move_list lput current_move move_list
    ]

    ask participants [
       send-info-to-clients
    ]
    tick ;; This tick operation is necessary to make the updates show up on "View".
  ]

end

;;
;; HubNet Procedures
;;

to listen-clients
  ;; as long as there are more messages from the clients
  ;; keep processing them.
  while [ hubnet-message-waiting? ]
  [
    ;; get the first message in the queue
    hubnet-fetch-message
    ifelse hubnet-enter-message? ;; when clients enter we get a special message
    [ create-new-participant ]
    [
      ifelse hubnet-exit-message? ;; when clients exit we get a special message
      [ remove-participant ]
      [
        ask participants with [user-id = hubnet-message-source]
        [
          execute-command hubnet-message-tag
        ]
      ]
    ]
  ]

end


to execute-command [command]

  if is-player? hubnet-message-source [

    if command = "View" [

      let xx round item 0 hubnet-message
      let yy round item 1 hubnet-message

      if (not isBlack?) and (white = chess-color hubnet-message-source)[
        set current_move (list xx yy white)
        set isNewMove? true
        stop
      ]

      if (isBlack?) and (red = chess-color hubnet-message-source)[
        set current_move (list xx yy red)
        set isNewMove? true
        stop
      ]
    ]
  ]
end


;;This procedure is to set up the location and links with other pieces
to dealOneHandofChessWithXY [mX mY myColor]

  ;Change the shape and size of the chess piece
  set shape "circle"
  set size 0.5

  set color myColor
  setxy mX mY

  markNodeListInColor sort boardspaces blue

  ifelse (myColor = white) [
    create-white-links-with other whitepieces in-radius 1 [
      set thickness 0.2
    ]

    ask one-of whitepieces in-radius 0 [
        set currentNumberOfLinkedPieces count link-neighbors
    ]

  ][
    create-black-links-with other blackpieces in-radius 1 [
      set thickness 0.2
    ]

    ask one-of blackpieces in-radius 0 [
        set currentNumberOfLinkedPieces count link-neighbors
    ]
  ]
end


;; This function provides the overall logical structure to determine whether one may or may not deal hand.
to-report canDealHand? [x y chess_is_black?]

  let isSurrounded? false
  let patchEmpty? true
  let hasEnemyToKill? false


  let chess_color "white"
  let friendlyCount 0
  let enemyCount 0
  let spaceCount 0

  let isLastFriendlyEmptySpot? isLastEmptySpaceOfColor? x y false

  ask patch x y [
    set spaceCount count boardspaces in-radius 1

    set friendlyCount count whitepieces in-radius 1
    set enemyCount count blackpieces in-radius 1

    if (chess_is_black?)[
      set chess_color "black"
      set friendlyCount count blackpieces in-radius 1
      set enemyCount count whitepieces in-radius 1
      set isLastFriendlyEmptySpot? isLastEmptySpaceOfColor? x y true
    ]
  ]

  if isLastFriendlyEmptySpot?[
    ;; Check if this spot has more non-occupied spaces
    if (spaceCount - (friendlyCount + enemyCount)) > 1[
      set isLastFriendlyEmptySpot? false
    ]

    let piecesToBeKilled findEnemyPiecesForKill x y chess_is_black?
    if (0 < length piecesToBeKilled ) [
      set hasEnemyToKill? true
    ]
  ]



  let okToDeal true
  set patchEmpty? (isPatchEmpty? x y)
  set okToDeal patchEmpty? and (not isLastFriendlyEmptySpot?) or hasEnemyToKill?

  ifelse not okToDeal [
    set isNewMove? false
    if not patchEmpty?[
      user-message word "The location " word x word ", " word y " is occupied!"
    ]

    if isLastFriendlyEmptySpot?[
      user-message word "The location is the last empty spot (chi) for the friendly " word chess_color " pieces"
    ]
  ][
    ;; if this is allowed to deal, check if this violates the ko condition
    if (koX = x) and (koY = y)[
      let piecesToBeKilled findEnemyPiecesForKill x y chess_is_black?
      if (1 = length piecesToBeKilled)[
        set okToDeal false
        set isNewMove? false
        user-message word "This piece place on " word x word ", " word y " is a violation of the Ko rule."
      ]
    ]
  ]

  report okToDeal
end

;; This procedure checks if the selected location is completely surrounded by Enemy or not
to-report findEnemyPiecesForKill [mX mY is_black?]

  let chessList []
  let neighboringEnemyChessList []
  let deadChessList []

  ifelse is_black? [
    set chessList whitepieces  ;; For black being placed at mX mY, search for whitepieces
  ][
    set chessList blackpieces  ;; For white being placed at mX mY, search for blackpieces
  ]

  ;;This code block will create neighboringEnemyChessList that contains the opponents' immeidately adjaceny chess pieces
  ask patch mX mY [
    ask chessList in-radius 1 [
      if not member? self neighboringEnemyChessList  [
        set neighboringEnemyChessList lput self neighboringEnemyChessList
      ]
    ]
  ]

  ;;Go through each immediately adjaceny enemy chess piece, and see if it is eligible for kill.
  foreach neighboringEnemyChessList [ enemyChess ->

    ;;Find all connected enemy pieces starting from the chosen "enemyChess"
    let connectedEnemies findNeighbors (list enemyChess)

    ;;Evaluate to know how many remaining chi that this branch of chess has
    let emptySpots findChis connectedEnemies
    let spaceCount length emptySpots ;;This is set to a large number, so that we know that it is not 1 or 0

    ;;If the only available chi (spaceCount = 1) is the empty spot to be occupied, we can start constructing a deadChessList
    if (spaceCount = 1)[
      ;; user-message (word "Is surrounded by chess with " word spaceCount " chi." )
      ;; If the surrounded ememy chess only has one chi left, then send "die" message to all of them
      foreach connectedEnemies [ aChess ->
        if not member? aChess deadChessList [
          set deadChessList lput aChess deadChessList
        ]
      ]
    ]
  ]

  report deadChessList

end

;A neighbor search function that identifies all chesspieces of same color that are connected
to-report findNeighbors [ nodeList ]
  let aList nodeList
  let initialCount 0

  while [initialCount < length aList]
  [
  set initialCount length aList
  foreach aList [ vNode ->
      ask vNode [
        ask link-neighbors [
          if not member? self aList  [
            set aList lput self aList
          ]
        ]
      ]
    ]
  ]
  report aList

end

;; Given a list of black or white pieces,
;; find all the boardspaces next to them
;; and return them in a list.
to-report findChis [ nodeList ]
  let newList []

  foreach nodeList [ vNode ->
    ask vNode[
      ask boardspaces in-radius 1 [
          if not member? self newList  [
            ;;Check if aSpace is an instance of breed boardspaces
            ifelse is-boardspace? self [
              let mX ([xcor] of self)
              let mY ([ycor] of self)
              if isPatchEmpty? mX mY[
                set newList lput self newList
              ]
            ][
              user-message (word "This is not an instance of boardspace" self)
            ]
          ]
      ]
   ]
  ]

  report newList

end

;; Given black or white choices,
;; return a boolean value indicating whether
to-report isLastEmptySpaceOfColor? [mX mY isBlackPiece?]
  let isLastEmptySpot? false

  ask patch mX mY [

    let spaceCount count boardspaces in-radius 1
    let friendlyCount count whitepieces in-radius 1
    let enemyCount count blackpieces in-radius 1

    let friendlyPieces whitepieces
    if isBlackPiece? [
      set friendlyPieces blackpieces
      set friendlyCount count blackpieces in-radius 1
      set enemyCount count whitepieces in-radius 1
    ]

    let neighbhorpieces friendlyPieces in-radius 1

    let nbs findNeighbors sort neighbhorpieces
    let availableChis findChis nbs
    markNodeListInColor availableChis cyan
    if 1 >= length availableChis[
      set isLastEmptySpot? true
    ]

    if (enemyCount >= (spaceCount - 1))[
      set isLastEmptySpot? true
    ]
  ]
  report isLastEmptySpot?
end


to-report isPatchEmpty? [mX mY]
  let emptyStatus? false

  ;;Check if anEmptySpace is an instance of breed boardspaces

    let totalCount 0
    ask patch mX mY [
      ask whitepieces in-radius 0 [
        set totalCount 1 + totalCount
      ]

      ask blackpieces in-radius 0 [
        set totalCount 1 + totalCount
      ]

      ifelse totalCount = 0 [
        set emptyStatus? true
      ][
        set emptyStatus? false
      ]
    ]

  report emptyStatus?

end


to markNodeListInColor [turtleList aColor]
  foreach turtleList [anObj ->
    ask anObj [
      set color aColor
      set shape "circle"
      set size 0.2
    ]
  ]
end

to-report numBlacks
  report count blackpieces
end

to-report numWhites
  report count whitepieces
end

to-report currentlyLinkedNodes
  report currentNumberOfLinkedPieces
end

;; This procedure loads an SGF formated game data from a file.
to load-game-data

  ;;first clear the board
  setup

  set GAME_FILE_NAME user-file

  ;; Must make usre that textline-data is initialized to a list
  let textline-data []

  ;; We check to make sure the file exists first
  ifelse ( file-exists? GAME_FILE_NAME )
  [
    ;; This opens the file, so we can use it.
    file-open GAME_FILE_NAME

    ;; Read in all the data in the file
    while [ not file-at-end? ]
    [
      set textline-data lput file-read-line textline-data
    ]

    let i 0
    let move-data []
    set move_list []
    while [i < length textline-data] [
      let aStr item i textline-data

      if 1 < length aStr [

        if (substring aStr 0 5 = "(;SZ[")[
          let sizeStr substring aStr 5 7
          ifelse last sizeStr = "]"[
            set num_lines but-last sizeStr
          ][
            set num_lines sizeStr
          ]
          print word "Board Size: " num_lines
        ]

        if (substring aStr 0 3 = ";B[") or (substring aStr 0 3 = ";W[")[
          while [6 <= length aStr and ((substring aStr 0 3 = ";B[") or (substring aStr 0 3 = ";W["))][
            let myMove substring aStr 1 6
            set move-data lput myMove move-data
            set move_list lput interpretMove myMove move_list
            set aStr substring aStr 6 length aStr
          ]
       ]
      ]
    set i (i + 1)
    ]

    ;; Done reading in patch information.  Close the file.
    file-close
  ]
  [ user-message word "There is no " word GAME_FILE_NAME " file in current directory!" ]

  foreach move_list [ aMove ->
    playing_by_the_rules aMove
  ]
  ask participants [ send-info-to-clients ]
end


;;This function tries to integrate all the rules
;;So that either loading a game from SGF file, or playing by hand
;;will reach the same results.
to playing_by_the_rules [ someMove ]

  let mX item 1 someMove
  let mY item 2 someMove

  if (canDealHand? mX mY isBlack?) [
      set koX -1
      set koY -1

      let deadChessList (findEnemyPiecesForKill mX mY isBlack?)

      if 1 = length deadChessList [
        let aChess last deadChessList
        set koX [xcor] of aChess
        set koY [ycor] of aChess
      ]

      foreach deadChessList [ aChess ->
        ask aChess [
          die
        ]
      ]

      ifelse isBlack?[
        create-blackpieces 1 [
          dealOneHandofChessWithXY mX mY red
          set isBlack? false
          set isNewMove? false
        ]
      ][
        create-whitepieces 1 [
          dealOneHandofChessWithXY mX mY white
          set isBlack? true
          set isNewMove? false
        ]
      ]
    ]

end

;; This procedure does the same thing as the above one, except it lets the user choose
;; the file to load from.  Note that we need to check that it isn't false.  This because
;; it will return false if the user cancels the file dialog.  There is currently only
;; one file to load from, but you can create your own using the function save-patch-data
;; near the bottom which saves all the current patches into a file.
to save-game-data
  let MOVE_COUNT 12
  let file user-new-file

  if ( file != false )
  [

    file-open file
    file-print word "(;SZ[" word num_lines "]"

    let a_line ""
    let i 0
    while [i < length move_list] [
      let aMove item i move_list
      set i i + 1
      let myColor item 0 aMove
      let x getChar item 1 aMove
      let y getChar item 2 aMove

      set a_line word a_line word ";" word myColor word "[" word x word y "]"

      if (i >= MOVE_COUNT) and (i mod MOVE_COUNT = 0) [
        file-print a_line
        set a_line ""
      ]
    ]

    if (i mod MOVE_COUNT > 0) [file-print a_line]

    file-print ")"
    user-message "File saving complete!"
    file-close
  ]
end

;; This procedure will use the loaded in patch data to color the patches.
;; The list is a list of three-tuples where the first item is the pxcor, the
;; second is the pycor, and the third is pcolor. Ex. [ [ 0 0 5 ] [ 1 34 26 ] ... ]
to show-game-data
  print move_list
end

to-report interpretMove [aString]
  let moveTriple []
  let myColor first aString
  let xCoordStr substring aString 2 3
  let yCoordStr substring aString 3 4

  let xCoord getNum xCoordStr
  let yCoord getNum yCoordStr

  set moveTriple lput myColor moveTriple
  set moveTriple lput xCoord moveTriple
  set moveTriple lput yCoord moveTriple

  report moveTriple

end

to-report getNum [aChar]
  let num -1
  let CHARACTERSET "abcdefghijklmnopqrstuvwxyz"
  if (length aChar = 1)[
    let i 0
    while [i <= length CHARACTERSET ][
      if (item i CHARACTERSET = aChar)[
        set num i
        set i length CHARACTERSET
      ]
      set i i + 1
    ]
  ]
  report num
end

to-report getChar [aNum]
  let char "\n"
  let CHARACTERSET "abcdefghijklmnopqrstuvwxyz"
  if (aNum < 26)[
    set char item aNum CHARACTERSET
  ]
  report char
end

;;
;; HubNet Procedures
;;

;; when a new user logs in create a participant turtle
;; this turtle will store any state on the client
;; values of sliders, etc.
to create-new-participant
  create-participants 1
  [
    ;; store the message-source in user-id now
    ;; so when you get messages from this client
    ;; later you will know which turtle it affects
    set user-id hubnet-message-source
    set label user-id

    if not (member? user-id participant_list) [
      set participant_list lput user-id participant_list
    ]
    ;; initialize turtle variables to the default
    ;; value of the corresponding widget in the client interface

    ;; update the clients with any information you have set
    send-info-to-clients
  ]
end

;; when a user logs out make sure to clean up the turtle
;; that was associated with that user (so you don't try to
;; send messages to it after it is gone) also if any other
;; turtles of variables reference this turtle make sure to clean
;; up those references too.
to remove-participant
  ask participants with [user-id = hubnet-message-source]
  [
    set participant_list remove user-id participant_list
    die
  ]
end

to-report is-player? [player-id]
  let player-status? false
  ifelse ( length participant_list >= 2)[
    if (player-id = item 0 participant_list) [set player-status? true]
    if (player-id = item 1 participant_list) [set player-status? true]
  ][
    user-message word "Not enough participants. Current participant count: " length participant_list
  ]

  report player-status?
end

to-report chess-color [player-id]
  let myColor false
  ifelse ( length participant_list >= 2)[
    if (player-id = item 0 participant_list) [set myColor red]
    if (player-id = item 1 participant_list) [set myColor white]
  ][
    user-message word "Not enough participants. Current participant count: " length participant_list
  ]

  report myColor
end

to show-participants
  foreach participant_list [ obj ->
    show obj
  ]
end

;; whenever something in world changes that should be displayed in
;; a monitor on the client send the information back to the client
to send-info-to-clients ;; turtle procedure
  hubnet-send user-id "Black Piece" count blackpieces
  hubnet-send user-id "White Piece" count whitepieces
  hubnet-send user-id "Total Hands Dealt" num-of-moves
end

to-report num-of-moves
  report length move_list
end
; Public Domain:
; This model is written as an exercise to learn NetLogo
@#$#@#$#@
GRAPHICS-WINDOW
231
10
619
399
-1
-1
20.0
1
10
1
1
1
0
0
0
1
0
18
0
18
1
1
0
ticks
30.0

BUTTON
34
51
105
84
NIL
setup
NIL
1
T
OBSERVER
NIL
NIL
NIL
NIL
1

BUTTON
107
51
178
84
NIL
go
T
1
T
OBSERVER
NIL
NIL
NIL
NIL
0

BUTTON
36
339
216
372
Load Game (SGF format)
load-game-data
NIL
1
T
OBSERVER
NIL
L
NIL
NIL
1

BUTTON
36
379
218
412
Save current Game
save-game-data
NIL
1
T
OBSERVER
NIL
NIL
NIL
NIL
1

MONITOR
68
285
189
330
Total Hands Dealt
num-of-moves
17
1
11

@#$#@#$#@
## WHAT IS IT?

This template contains code that can serve as a starting point for creating new HubNet activities. It shares many of the basic procedures used by other HubNet activities, which are required to connect to and communicate with clients in Disease-like activities.

## HOW IT WORKS

In activities like Disease, each client controls a single turtle on the server.  These turtles are a breed called STUDENTS.  When a client logs in we create a new student turtle and set it up with the default attributes.  Students own a variable for every widget on the client that holds a state, that is, sliders, switches, choosers, and input boxes.  Whenever a user changes one of these elements on the client, a message is sent to the server.  The server catches the message and stores the result.  In this example a slider is used to demonstrate this behavior.  You can also send messages to the client-side widgets using `hubnet-send`.  Monitors on clients must be updated manually by the model, that is you must send a message to a monitor every time you want the value displayed to change. For example, if you have a monitor that displays the current location of the client's avatar, you must send a message to the client like this:

     hubnet-send user-id "location" (word xcor " " ycor)

whenever the client moves.  Buttons on the client side send but do not receive messages.  When a user presses a button, a message is sent to the server.  The server catches the message and executes the appropriate commands.  In this case, the commands should always be turtle commands since the clients control only a single turtle.

## HOW TO USE IT

To start the activity press the GO button.  Ask students to login using the HubNet client or you can test the activity locally by pressing the LOCAL button in the HubNet Control Center. To see the view in the client interface check the Mirror 2D view on clients checkbox.  The clients can use the UP, DOWN, LEFT, and RIGHT buttons to move their avatar and change the amount they move each step by changing the STEP-SIZE slider.

<!-- 2007 -->
@#$#@#$#@
default
true
0
Polygon -7500403 true true 150 5 40 250 150 205 260 250

airplane
true
0
Polygon -7500403 true true 150 0 135 15 120 60 120 105 15 165 15 195 120 180 135 240 105 270 120 285 150 270 180 285 210 270 165 240 180 180 285 195 285 165 180 105 180 60 165 15

arrow
true
0
Polygon -7500403 true true 150 0 0 150 105 150 105 293 195 293 195 150 300 150

box
false
0
Polygon -7500403 true true 150 285 285 225 285 75 150 135
Polygon -7500403 true true 150 135 15 75 150 15 285 75
Polygon -7500403 true true 15 75 15 225 150 285 150 135
Line -16777216 false 150 285 150 135
Line -16777216 false 150 135 15 75
Line -16777216 false 150 135 285 75

bug
true
0
Circle -7500403 true true 96 182 108
Circle -7500403 true true 110 127 80
Circle -7500403 true true 110 75 80
Line -7500403 true 150 100 80 30
Line -7500403 true 150 100 220 30

butterfly
true
0
Polygon -7500403 true true 150 165 209 199 225 225 225 255 195 270 165 255 150 240
Polygon -7500403 true true 150 165 89 198 75 225 75 255 105 270 135 255 150 240
Polygon -7500403 true true 139 148 100 105 55 90 25 90 10 105 10 135 25 180 40 195 85 194 139 163
Polygon -7500403 true true 162 150 200 105 245 90 275 90 290 105 290 135 275 180 260 195 215 195 162 165
Polygon -16777216 true false 150 255 135 225 120 150 135 120 150 105 165 120 180 150 165 225
Circle -16777216 true false 135 90 30
Line -16777216 false 150 105 195 60
Line -16777216 false 150 105 105 60

car
false
0
Polygon -7500403 true true 300 180 279 164 261 144 240 135 226 132 213 106 203 84 185 63 159 50 135 50 75 60 0 150 0 165 0 225 300 225 300 180
Circle -16777216 true false 180 180 90
Circle -16777216 true false 30 180 90
Polygon -16777216 true false 162 80 132 78 134 135 209 135 194 105 189 96 180 89
Circle -7500403 true true 47 195 58
Circle -7500403 true true 195 195 58

circle
false
0
Circle -7500403 true true 0 0 300

circle 2
false
0
Circle -7500403 true true 0 0 300
Circle -16777216 true false 30 30 240

cow
false
0
Polygon -7500403 true true 200 193 197 249 179 249 177 196 166 187 140 189 93 191 78 179 72 211 49 209 48 181 37 149 25 120 25 89 45 72 103 84 179 75 198 76 252 64 272 81 293 103 285 121 255 121 242 118 224 167
Polygon -7500403 true true 73 210 86 251 62 249 48 208
Polygon -7500403 true true 25 114 16 195 9 204 23 213 25 200 39 123

cylinder
false
0
Circle -7500403 true true 0 0 300

dot
false
0
Circle -7500403 true true 90 90 120

face happy
false
0
Circle -7500403 true true 8 8 285
Circle -16777216 true false 60 75 60
Circle -16777216 true false 180 75 60
Polygon -16777216 true false 150 255 90 239 62 213 47 191 67 179 90 203 109 218 150 225 192 218 210 203 227 181 251 194 236 217 212 240

face neutral
false
0
Circle -7500403 true true 8 7 285
Circle -16777216 true false 60 75 60
Circle -16777216 true false 180 75 60
Rectangle -16777216 true false 60 195 240 225

face sad
false
0
Circle -7500403 true true 8 8 285
Circle -16777216 true false 60 75 60
Circle -16777216 true false 180 75 60
Polygon -16777216 true false 150 168 90 184 62 210 47 232 67 244 90 220 109 205 150 198 192 205 210 220 227 242 251 229 236 206 212 183

fish
false
0
Polygon -1 true false 44 131 21 87 15 86 0 120 15 150 0 180 13 214 20 212 45 166
Polygon -1 true false 135 195 119 235 95 218 76 210 46 204 60 165
Polygon -1 true false 75 45 83 77 71 103 86 114 166 78 135 60
Polygon -7500403 true true 30 136 151 77 226 81 280 119 292 146 292 160 287 170 270 195 195 210 151 212 30 166
Circle -16777216 true false 215 106 30

flag
false
0
Rectangle -7500403 true true 60 15 75 300
Polygon -7500403 true true 90 150 270 90 90 30
Line -7500403 true 75 135 90 135
Line -7500403 true 75 45 90 45

flower
false
0
Polygon -10899396 true false 135 120 165 165 180 210 180 240 150 300 165 300 195 240 195 195 165 135
Circle -7500403 true true 85 132 38
Circle -7500403 true true 130 147 38
Circle -7500403 true true 192 85 38
Circle -7500403 true true 85 40 38
Circle -7500403 true true 177 40 38
Circle -7500403 true true 177 132 38
Circle -7500403 true true 70 85 38
Circle -7500403 true true 130 25 38
Circle -7500403 true true 96 51 108
Circle -16777216 true false 113 68 74
Polygon -10899396 true false 189 233 219 188 249 173 279 188 234 218
Polygon -10899396 true false 180 255 150 210 105 210 75 240 135 240

house
false
0
Rectangle -7500403 true true 45 120 255 285
Rectangle -16777216 true false 120 210 180 285
Polygon -7500403 true true 15 120 150 15 285 120
Line -16777216 false 30 120 270 120

leaf
false
0
Polygon -7500403 true true 150 210 135 195 120 210 60 210 30 195 60 180 60 165 15 135 30 120 15 105 40 104 45 90 60 90 90 105 105 120 120 120 105 60 120 60 135 30 150 15 165 30 180 60 195 60 180 120 195 120 210 105 240 90 255 90 263 104 285 105 270 120 285 135 240 165 240 180 270 195 240 210 180 210 165 195
Polygon -7500403 true true 135 195 135 240 120 255 105 255 105 285 135 285 165 240 165 195

line
true
0
Line -7500403 true 150 0 150 300

line half
true
0
Line -7500403 true 150 0 150 150

pentagon
false
0
Polygon -7500403 true true 150 15 15 120 60 285 240 285 285 120

person
false
0
Circle -7500403 true true 110 5 80
Polygon -7500403 true true 105 90 120 195 90 285 105 300 135 300 150 225 165 300 195 300 210 285 180 195 195 90
Rectangle -7500403 true true 127 79 172 94
Polygon -7500403 true true 195 90 240 150 225 180 165 105
Polygon -7500403 true true 105 90 60 150 75 180 135 105

plant
false
0
Rectangle -7500403 true true 135 90 165 300
Polygon -7500403 true true 135 255 90 210 45 195 75 255 135 285
Polygon -7500403 true true 165 255 210 210 255 195 225 255 165 285
Polygon -7500403 true true 135 180 90 135 45 120 75 180 135 210
Polygon -7500403 true true 165 180 165 210 225 180 255 120 210 135
Polygon -7500403 true true 135 105 90 60 45 45 75 105 135 135
Polygon -7500403 true true 165 105 165 135 225 105 255 45 210 60
Polygon -7500403 true true 135 90 120 45 150 15 180 45 165 90

square
false
0
Rectangle -7500403 true true 30 30 270 270

square 2
false
0
Rectangle -7500403 true true 30 30 270 270
Rectangle -16777216 true false 60 60 240 240

star
false
0
Polygon -7500403 true true 151 1 185 108 298 108 207 175 242 282 151 216 59 282 94 175 3 108 116 108

target
false
0
Circle -7500403 true true 0 0 300
Circle -16777216 true false 30 30 240
Circle -7500403 true true 60 60 180
Circle -16777216 true false 90 90 120
Circle -7500403 true true 120 120 60

tree
false
0
Circle -7500403 true true 118 3 94
Rectangle -6459832 true false 120 195 180 300
Circle -7500403 true true 65 21 108
Circle -7500403 true true 116 41 127
Circle -7500403 true true 45 90 120
Circle -7500403 true true 104 74 152

triangle
false
0
Polygon -7500403 true true 150 30 15 255 285 255

triangle 2
false
0
Polygon -7500403 true true 150 30 15 255 285 255
Polygon -16777216 true false 151 99 225 223 75 224

truck
false
0
Rectangle -7500403 true true 4 45 195 187
Polygon -7500403 true true 296 193 296 150 259 134 244 104 208 104 207 194
Rectangle -1 true false 195 60 195 105
Polygon -16777216 true false 238 112 252 141 219 141 218 112
Circle -16777216 true false 234 174 42
Rectangle -7500403 true true 181 185 214 194
Circle -16777216 true false 144 174 42
Circle -16777216 true false 24 174 42
Circle -7500403 false true 24 174 42
Circle -7500403 false true 144 174 42
Circle -7500403 false true 234 174 42

turtle
true
0
Polygon -10899396 true false 215 204 240 233 246 254 228 266 215 252 193 210
Polygon -10899396 true false 195 90 225 75 245 75 260 89 269 108 261 124 240 105 225 105 210 105
Polygon -10899396 true false 105 90 75 75 55 75 40 89 31 108 39 124 60 105 75 105 90 105
Polygon -10899396 true false 132 85 134 64 107 51 108 17 150 2 192 18 192 52 169 65 172 87
Polygon -10899396 true false 85 204 60 233 54 254 72 266 85 252 107 210
Polygon -7500403 true true 119 75 179 75 209 101 224 135 220 225 175 261 128 261 81 224 74 135 88 99

wheel
false
0
Circle -7500403 true true 3 3 294
Circle -16777216 true false 30 30 240
Line -7500403 true 150 285 150 15
Line -7500403 true 15 150 285 150
Circle -7500403 true true 120 120 60
Line -7500403 true 216 40 79 269
Line -7500403 true 40 84 269 221
Line -7500403 true 40 216 269 79
Line -7500403 true 84 40 221 269

x
false
0
Polygon -7500403 true true 270 75 225 30 30 225 75 270
Polygon -7500403 true true 30 75 75 30 270 225 225 270
@#$#@#$#@
NetLogo 6.0.1
@#$#@#$#@
need-to-manually-make-preview-for-this-model
@#$#@#$#@
@#$#@#$#@
@#$#@#$#@
VIEW
13
10
443
440
0
0
0
1
1
1
1
1
0
1
1
1
0
18
0
18

MONITOR
449
11
528
60
Black Piece
NIL
3
1

MONITOR
450
390
531
439
White Piece
NIL
3
1

MONITOR
451
201
572
250
Total Hands Dealt
NIL
3
1

@#$#@#$#@
default
0.0
-0.2 0 0.0 1.0
0.0 1 1.0 0.0
0.2 0 0.0 1.0
link direction
true
0
Line -7500403 true 150 150 90 180
Line -7500403 true 150 150 210 180
@#$#@#$#@
0
@#$#@#$#@
