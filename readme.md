# Petition Platform

This platform was put together at the behest of both DSG and the Graduate Student Council. Its need has become apparent as student activism has increased and the desire for a simplified interface to voice opinions to administration has developed. The Petition Platform has several goals, outlined below:

 - To allow students to create petitions in a consistent way, facilitating the voicing of powerful opinions
 - To give administration a streamlined interface to answer official requests by the general student body (<3 Larry Moneta)
 - That's basically it?
 
## Architecture

The Design of the Petition platform follows its goals. Modular design should allow for future expansion and integration, as well as proper separation of labor between back-end dev, data management, front-end dev, styling, etc. For this reason, the back-end utilizes a simple php core to provide a data-only API, with a static front-end that pulls and renders this data. The template engine Handlebars will be executing the rendering of petition templates, etc. Authentication, in version 1 at least, will be accomplished with shibboleth, which can guarantee that a netid has logged in and extract the netid using Duke's SSO system.

### Data Structures

#### Petitions

 - id: A unique identifier for the petition
 - name: A short name to identify the petition
 - author: netid of the author of the petition
 - blurb: A short description to explain the intent of the petition
 - content: The full petition text
 - response: A string containing any response from admins (Larry Moneta <3)
 - tags: a JSON array of strings that can be used for searching and classifying the petition
 - category: A single string (chosen from a set list of categories) used to group petitions
 - count: A full count of voters (necessary to display the vote count without exposing all of the voters' identities to the client)
 - date: unix time (millis) of the first listing of the petition

#### Votes
 - netid: netid of the voter
 - name: name of the voter
 - comment: 512 character comment by the voter (should explain why they supported the petition)
 - timestamp: unix milliseconds timestamp

#### Users

 - netid: unique netid
 - lastvote: unix time (millis) of the last vote made by the user
 - petitionid: id of the petition the vote is for
 - remainingVotes: number of votes remaining for the day for the user
 - admin: boolean representing whether the user is an admin

#### Categories
 - category: string of the category
 - description: short explanation of the category's scope

### Interface

#### Student

*As with all of our systems, UI settings (like sort order, etc) is saved locally in the browser of the user. This prevents having to deal with storage of non-essential data while still providing users with a somewhat consistent UI experience.*

The main student-facing interface takes the form of a listing of petition names, blurbs, and vote counts. The list is sortable by date, votes, and randomly (with date (most recent first) being the default). The list is searchable by tag, category, and content. An interface also allows the browsing of categories individually.

When a petition is selected, it expands (its data re-rendered using a different handlebars template) to list the entire text, and provide users a button to press to add their netid to the voter list.

The interface also explains the votes/day system and displays the number of votes left for that day.

The system is designed to allow users to vote a set number of times per day (probably 3). Votes can be counted multiple times for the same petition. This is represented in the petition structure itself as multiple additions of the same netid to the 'votes' attribute. 
 
#### Administration

The administration interface allows direct response from specific netids. It is identical to the student interface, but the expanded rendering of petitions includes a textbox for responses to petitions and allows their submission.

### Directory Structure

The structure below is an explanation of the directory structure of the repo:


|Resource     | Description |
| ------------ | ------------- |
| /            | Root Directory |
| /client      | Contains the entire client side app (secured by shib) |
| /client/js   | All javascript sources |
| /client/js/petitions.js | All custom JS is compiled to here |
| /client/css  | All style sources |
| /client/style.css | All custom CSS is compiled to here |
| /client/index.html | Main (and probably only) page |
| /backend     | Backend data api (secured by shib) |
| /backend/petitions | A GET request returns a JSON array of all petitions. a POST request validates and saves a new petition |
| /backend/petitions/:petitionid | A POST request votes for the petition as the user. a DELETE request by the *author* removes it |
| /backend/categories | A GET request returns a JSON array of categories. A POST request adds a new category (admin only) |
| /backend/votesLeft | A GET request returns the number of votes left for a user |
| /backend/admins | A GET request lists all admins. A POST request adds a netid as an admin |
| /backend/admins/:netid | A DELETE request removes admin privileges of a user |
| /api         | Placeholder for the Co-Lab style API (not secured by shib) |