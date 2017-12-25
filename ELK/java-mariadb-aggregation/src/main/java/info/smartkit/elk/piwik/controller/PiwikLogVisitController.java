package info.smartkit.elk.piwik.controller;

import com.google.gson.Gson;
import com.google.gson.JsonArray;
import info.smartkit.elk.piwik.response.PiwikLogVisitResponse;
import info.smartkit.elk.service.PiwikLogVisitService;
import info.smartkit.elk.service.converter.PiwikLogVisitConverter;
import io.swagger.annotations.Api;
import io.swagger.annotations.ApiOperation;
import io.swagger.annotations.ApiParam;
import net.logstash.logback.marker.Markers;
import org.json.simple.JSONArray;
import org.omg.CORBA.OBJ_ADAPTER;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.sql.SQLException;
import java.util.List;
import java.util.Timer;
import java.util.TimerTask;
import java.util.stream.Collectors;

import static net.logstash.logback.marker.Markers.append;
import static net.logstash.logback.marker.Markers.appendRaw;
import static net.logstash.logback.marker.Markers.appendArray;


@Api(value = "/users", description = "API manages 'users' allowing to perform basic CRUD operations")
@RestController
@RequestMapping("/piwik/log/visit") class PiwikLogVisitController {

    private static final Logger LOGGER = LoggerFactory.getLogger(PiwikLogVisitController.class);

    @Autowired
    private PiwikLogVisitService piwikLogVisitService;

    @Autowired
    private PiwikLogVisitConverter converter;

    @ApiOperation(
            value = "Retrieve 'request' by Id",
            notes = "Allows to retrieve existing 'request' resource by its identifier",
            response = PiwikLogVisitResponse.class
    )
    @RequestMapping(value = "/{userId}", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public String getPiwikLogVisit(@ApiParam(value = "Unique 'request' identifier") @PathVariable final Long piwikLogVisitId) {
        LOGGER.debug("Trying to retrieve PiwikLogVisit by ID: " + piwikLogVisitId);
        return toJson(this.converter.convert(this.piwikLogVisitService.getPiwikLogVisit(piwikLogVisitId)));
    }

    @ApiOperation(
            value = "Retrieve all 'users'",
            notes = "Allows to retrieve all existing 'PiwikLogVisit'",
            response = PiwikLogVisitResponse.class,
            responseContainer = "Set"
    )
    @RequestMapping(method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public String getAllPiwikLogVisits() throws SQLException {
        LOGGER.debug("Trying to retrieve all PiwikLogVisits");
//
        JSONArray rawListObjects = piwikLogVisitService.getAllPiwikLogVisitsRaw();
//        String jsonString = toJson(
//                piwikLogVisitService.getAllPiwikLogVisits().stream()
//                        .map(user -> this.converter.convert(user)).collect(Collectors.toSet()));
//        LOGGER.info(append("HeartbeatPiwik[]", "HeartbeatPiwik"), "HeartbeatPiwik details []", "HeartbeatPiwik[]");
//        String jsonRawString = toJson(rawListObjects);
        String jsonRawString = toJson(rawListObjects);

        int delay = 5000;   // delay for 5 sec.
        int period = rawListObjects.size()*delay;  // iterate every sec.
        Timer timer = new Timer();
//
        timer.scheduleAtFixedRate(new TimerTask() {

            public void run() {
                // Task here ...
                String jsonRawString = toJson(rawListObjects.get(0));
//                System.out.println("Piwik:"+jsonRawString);
                LOGGER.info(jsonRawString);
                LOGGER.info(String.valueOf(appendRaw("Piwik", jsonRawString)));
                rawListObjects.remove(0);
            }
        }, delay, period);
        return jsonRawString;
    }

    private static String toJson(Object object) {
        return new Gson().toJson(object);
    }

}
